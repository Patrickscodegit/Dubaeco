<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\ListingImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{
    // Show all listings
    public function index() {
        return view('listings.index', [
            'listings' => Listing::latest()->filter(request(['tag', 'search']))->paginate(6)
        ]);
    }

    // Show single listing
    public function show(Listing $listing) {
        return view('listings.show', [
            'listing' => $listing
        ]);
    }

    // Show Create Form
    public function create() {
        return view('listings.create');
    }

    // Store Listing Data
    public function store(Request $request) {
        $formFields = $request->validate([
            'title' => 'required|string|max:255',
            'company' => ['required', 'string', 'max:255', Rule::unique('listings', 'company')],
            'location' => 'required|string|max:255',
            'website' => 'required|url',
            'email' => ['required', 'email'],
            'tags' => 'required|string|max:255',
            'description' => 'required|string'
        ]);

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }

        // Add authenticated user ID to form fields
        $formFields['user_id'] = auth()->id();
        // Create the listing
        $listing = Listing::create($formFields);

        // Handle multiple image uploads
        $this->handleImages($request, $listing);

        return redirect('/')->with('message', 'Listing created successfully!');
    }

    // Show Edit Form
    public function edit(Listing $listing) {
        if (auth()->id() !== $listing->user_id) {
            abort(403, 'Unauthorized action.');
        }
        return view('listings.edit', ['listing' => $listing]);
    }
    

    public function update(Request $request, Listing $listing) {
        if (auth()->id() !== $listing->user_id) {
            abort(403, 'Unauthorized action.');
        }
    
        $formFields = $request->validate([
            'title' => 'required|string|max:255',
            'company' => ['required', 'string', 'max:255'],
            'location' => 'required|string|max:255',
            'website' => 'required|url',
            'email' => ['required', 'email'],
            'tags' => 'required|string|max:255',
            'description' => 'required|string',
            'logo' => 'nullable|image|max:5000',
        ]);
    
        if ($request->hasFile('logo')) {
            if ($listing->logo && Storage::disk('public')->exists($listing->logo)) {
                Storage::disk('public')->delete($listing->logo);
            }
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }
    
        $listing->update($formFields);
    
        if ($request->hasFile('images')) {
            // Optionally delete old images
            foreach ($listing->images as $image) {
                Storage::disk('public')->delete($image->image_path);
                $image->delete();
            }
            // Add new images
            foreach ($request->file('images') as $image) {
                $path = $image->store('listing_images', 'public');
                ListingImage::create([
                    'listing_id' => $listing->id,
                    'image_path' => $path
                ]);
            }
    
        return back()->with('message', 'Listing updated successfully!');
    }
}
    

// Delete Listing
public function destroy(Listing $listing) {
    // Manually check if the current authenticated user is the owner of the listing
    if (auth()->id() !== $listing->user_id) {
        abort(403, 'Unauthorized action.');
    }

    // Proceed with deletion if the user is authorized
    if ($listing->logo && Storage::disk('public')->exists($listing->logo)) {
        Storage::disk('public')->delete($listing->logo);
    }

    foreach ($listing->images as $image) {
        if (Storage::disk('public')->exists($image->image_path)) {
            Storage::disk('public')->delete($image->image_path);
        }
        $image->delete();
    }
    
    $listing->delete();
    return redirect('/')->with('message', 'Listing deleted successfully');
}


    // Manage Listings
    public function manage() {
        return view('listings.manage', [
            'listings' => Listing::where('user_id', auth()->id())->latest()->paginate(4)
        ]);
    }

    // Handle image uploads
    private function handleImages(Request $request, Listing $listing, $cleanup = false) {
        if ($request->hasFile('images')) {
            if ($cleanup) {
                foreach ($listing->images as $image) {
                    Storage::disk('public')->delete($image->image_path);
                    $image->delete();
                }
            }
            foreach ($request->file('images') as $image) {
                $path = $image->store('listing_images', 'public');
                ListingImage::create([
                    'listing_id' => $listing->id,
                    'image_path' => $path
                ]);
            }
        }
    }
}
