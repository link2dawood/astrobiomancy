<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use Concerns\Translatable;

    protected $table = 'testimonials';

    protected $fillable = [
        'lang', 'name', 'content', 'photo', 'display_date',
        'sort', 'status', 'translation_of',
    ];

    protected $dates = ['display_date'];

    public function scopePublished($query)
    {
        return $query->where('status', 'Published');
    }
}
