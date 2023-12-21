<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'identifier',
    ];

    public function books() {
        return $this->belongsToMany(Author::class, 'book_authors')->using(BookAuthor::class);
    }
}
