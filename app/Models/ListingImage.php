<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListingImage extends Model
{
    use HasFactory;

    protected $table = 'listing_images';
    protected $fillable = ['listing_id', 'image_path'];


    public function listing()
    {
        return $this->belongsTo(Listing::class);
    }

    // Accessor to get the full URL to the image
    public function getImageUrlAttribute()
    {
        return url('storage/' . $this->image_path);
    }
}


