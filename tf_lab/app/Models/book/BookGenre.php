<?php

namespace App\Models\book;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookGenre extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'text_color',
        'background_color',
    ];


}
