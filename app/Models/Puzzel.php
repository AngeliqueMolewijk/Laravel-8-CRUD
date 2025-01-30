<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Puzzel extends Model
{
    // use Sortable;
    // use HasFactory;
    protected $fillable = [
        'title',
        'image',
        'stukjes',
        'own',
        'gelegd'
    ];
    // public $sortable = ['title', 'own', 'gelegd', 'created_at'];
}
