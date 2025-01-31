<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use SDamian\Larasort\AutoSortable;

class Puzzel extends Model
{
    use AutoSortable;

    // use Sortable;
    // use HasFactory;

    /**
     * The attributes that are sortable.
     */

    protected $fillable = [
        'title',
        'image',
        'stukjes',
        'own',
        'gelegd'
    ];
    // public $sortable = ['title', 'own', 'gelegd', 'created_at'];
}
