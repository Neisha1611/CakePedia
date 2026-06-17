<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['recipe_id', 'user_id', 'parent_id', 'body', 'from_rating'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id')->with('user')->oldest();
    }

    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }
}