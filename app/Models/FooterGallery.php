<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FooterGallery extends Model
{
    protected $fillable = [
        'image',
        'status',
        'sort_order'
    ];
}