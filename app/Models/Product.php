<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'price',
        'about',
        'views',
        'thumbnail',
        'caption',
        'is_recommend',
        'category_id'
    ];

    protected $casts = [
        'is_recommend' => 'boolean',
    ];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function getPriceAttribute($value)
    {
        return 'Rp ' . number_format($value, 0, ',', '.');
    }

    public function setPriceAttribute($value)
    {
        // Hapus semua karakter selain angka sebelum disimpan ke database
        $this->attributes['price'] = preg_replace('/[^\d]/', '', $value);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function galleries()
    {
        return $this->hasMany(Gallery::class);
    }
}
