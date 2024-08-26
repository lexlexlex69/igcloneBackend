<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class postItems extends Model
{
    use HasFactory;
    protected $table = 'posts';
    protected $primaryKeys = 'id';
    protected $fillable = [
        'title', 'description', 'image', 'user_id'
    ];
}
