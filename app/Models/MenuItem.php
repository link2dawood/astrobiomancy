<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    use Concerns\Translatable;

    protected $table = 'menu_items';
    protected $fillable = ['lang', 'location', 'label', 'url', 'sort'];

    /**
     * Locations the UI can render. Add codes here when introducing new
     * placements (e.g. `account_dropdown`).
     */
    const LOCATIONS = [
        'header'           => 'Header (top nav)',
        'header_services'  => 'Header — Services dropdown',
        'footer_links'     => 'Footer — Links column',
        'footer_services'  => 'Footer — Services column',
        'footer_legal'     => 'Footer — Legal column',
    ];

    public function scopeAt($query, $location)
    {
        return $query->where('location', $location);
    }
}
