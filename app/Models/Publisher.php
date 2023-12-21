<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publisher extends Model
{
    use HasFactory;

    public $fillable = [
        'first_name',
        'last_name',
        'identifier',
    ];

    public function books() {
        return $this->hasMany(Book::class, 'publisher_id');
    }
}
