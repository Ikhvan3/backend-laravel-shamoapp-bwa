<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProductGallery extends Model
{
    protected $fillable = [
        'products_id',
        'url',
    ];

    protected $appends = ['full_url'];

    public function getFullUrlAttribute()
    {
        $url = asset('storage/' . $this->url);
        Log::info('Generated full URL: ' . $url);
        return $url;
    }
}
