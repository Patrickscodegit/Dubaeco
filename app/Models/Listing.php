<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;

    // Uncomment and update this if you need to allow mass assignment
    // protected $fillable = ['title', 'company', 'location', 'website', 'email', 'description', 'tags', 'user_id'];

    /**
     * Define a scope to filter listings based on search criteria.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  array  $filters
     * @return void
     */
    public function scopeFilter($query, array $filters) {
        if($filters['tag'] ?? false) {
            $query->where('tags', 'like', '%' . $filters['tag'] . '%');
        }

        if($filters['search'] ?? false) {
            $query->where(function($query) use ($filters) {
                $query->where('title', 'like', '%' . $filters['search'] . '%')
                      ->orWhere('description', 'like', '%' . $filters['search'] . '%')
                      ->orWhere('tags', 'like', '%' . $filters['search'] . '%');
            });
        }
    }

    /**
     * Relationship to User model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship to ListingImage model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images() {
        return $this->hasMany(ListingImage::class);
    }
}
