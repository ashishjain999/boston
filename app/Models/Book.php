<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'year',
        'page',
        'isbn',
        'publisher_id',
    ];

    public function publisher() {
        return $this->belongsTo(Publisher::class)->withDefault([
            'first_name' => 'WITHOUT ID',
            'last_name' => 'NOT FOUND',
            'identifier' => 'NOT FOUND',
        ]);
    }

    public function authors() {
        return $this->belongsToMany(Author::class, 'book_authors')->using(BookAuthor::class);
    }
}
