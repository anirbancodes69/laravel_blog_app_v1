<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{

    use HasFactory;

    protected $fillable = ['comment', 'rating'];

    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }

    // INVALIDATE CACHE
    protected static function booted()
    {
        //working in mass assign
        static::updated(fn(Comment $comment) => cache()->forget('blog:' . $comment->blog_id));
        static::deleted(fn(Comment $comment) => cache()->forget('blog:' . $comment->blog_id));
        static::created(fn(Comment $comment) => cache()->forget('blog:' . $comment->blog_id));
    }
}
