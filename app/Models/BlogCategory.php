<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{
    use HasFactory;

    public $fillable = ['id','name', 'slug', 'status'];

    public function blog()
    {
        return $this->hasMany(Blog::class, 'blog_category_id', 'id');
    }
    public function blogsCount()
    {
        return $this->blog()->count();
    }
    public static function categoriesWithBlogCounts()
    {
        return self::withCount('blog')->get();
    }
}
