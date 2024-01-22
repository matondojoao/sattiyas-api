<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostPostCategory extends Model
{
    protected $table = 'post_post_category';

    protected $fillable = [
        'post_id', 'post_category_id',
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function postCategory()
    {
        return $this->belongsTo(PostCategory::class);
    }
}
