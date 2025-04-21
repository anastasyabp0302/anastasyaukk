<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image_path',
        'category',
        'user_id',
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function isLikedBy($user) {
        return $this->likes->where('user_id', $user->id)->count() > 0;
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function isadmin()
    {
        return $this->role === 'admin';
    }
}
