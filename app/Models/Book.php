<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'title',
        'author',
        'publisher',
        'year',
        'stock',
        'description',
        'cover'
    ];
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    public function getCoverUrlAttribute()
    {
        return $this->cover 
            ? asset('storage/'.$this->cover) 
            : 'https://via.placeholder.com/300x400?text=No+Cover';
    }
}
