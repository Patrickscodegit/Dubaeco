<x-layout>
  <x-card class="p-10 max-w-lg mx-auto mt-24">
      <header class="text-center">
          <h2 class="text-2xl font-bold uppercase mb-1">Create a Listing</h2>
          <p class="mb-4">Post a Listing to find a buyer</p>
      </header>

      <form method="POST" action="/listings" enctype="multipart/form-data">
          @csrf

          <div class="mb-6">
            <label for="price" class="inline-block text-lg mb-2">
              Price
            </label>
            <textarea class="border border-gray-200 rounded p-2 w-full" name="price" rows="250" placeholder="price">{{ old('price') }}</textarea>
            @error('price')
            <p class="text-red-500 text-xs mt-1">{{$message}}</p>
            @enderror
          </div>

          <div class="mb-6">
              <label for="company" class="inline-block text-lg mb-2">Company Name</label>
              <input type="text" class="border border-gray-200 rounded p-2 w-full" name="company" value="{{ old('company') }}" />
              @error('company')
              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
              @enderror
          </div>

          <div class="mb-6">
              <label for="title" class="inline-block text-lg mb-2">Make and model</label>
              <input type="text" class="border border-gray-200 rounded p-2 w-full" name="title" placeholder="Example: Senior Laravel Developer" value="{{ old('title') }}" />
              @error('title')
              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
              @enderror
          </div>

          <div class="mb-6">
              <label for="location" class="inline-block text-lg mb-2">Car Location</label>
              <input type="text" class="border border-gray-200 rounded p-2 w-full" name="location" placeholder="Example: Remote, Boston MA, etc" value="{{ old('location') }}" />
              @error('location')
              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
              @enderror
          </div>

          <div class="mb-6">
              <label for="email" class="inline-block text-lg mb-2">Contact Email</label>
              <input type="text" class="border border-gray-200 rounded p-2 w-full" name="email" value="{{ old('email') }}" />
              @error('email')
              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
              @enderror
          </div>

          <div class="mb-6">
              <label for="website" class="inline-block text-lg mb-2">listing URL</label>
              <input type="text" class="border border-gray-200 rounded p-2 w-full" name="website" value="{{ old('website') }}" />
              @error('website')
              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
              @enderror
          </div>

          <div class="mb-6">
              <label for="tags" class="inline-block text-lg mb-2">Tags (Comma Separated)</label>
              <input type="text" class="border border-gray-200 rounded p-2 w-full" name="tags" placeholder="Example: Laravel, Backend, Postgres, etc" value="{{ old('tags') }}" />
              @error('tags')
              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
              @enderror
          </div>

          <div class="mb-6">
              <label for="logo" class="inline-block text-lg mb-2">Main picture</label>
              <input type="file" class="border border-gray-200 rounded p-2 w-full" name="logo" />
              @error('logo')
              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
              @enderror
          </div>

          <div class="mb-6">
              <label for="images" class="inline-block text-lg mb-2">Upload Images</label>
              <input type="file" class="border border-gray-200 rounded p-2 w-full" name="images[]" multiple />
              @error('images.*')
              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
              @enderror
              @error('images')
              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
              @enderror
          </div>

          <div class="mb-6">
            <label for="description" class="inline-block text-lg mb-2">
              Car Description
            </label>
            <textarea class="border border-gray-200 rounded p-2 w-full" name="description" rows="250" placeholder="Include tasks, requirements, salary, etc">{{ old('description') }}</textarea>
            @error('description')
            <p class="text-red-500 text-xs mt-1">{{$message}}</p>
            @enderror
          </div>
    
          <!-- Submission buttons -->
          <div class="mb-6">
            <button class="bg-laravel text-white rounded py-2 px-4 hover:bg-black">
              Create Listing
            </button>
            <a href="/" class="text-black ml-4"> Back </a>
          </div>
        </form>
      </x-card>
    </x-layout>