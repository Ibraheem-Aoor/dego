<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = ['id','blog_status','author_id','blogThumb','blogThumb_driver','meta_robots','og_description','breadcrumb_image_driver','breadcrumb_image','breadcrumb_status','blog_image_driver','blog_image','blog_category_id','meta_image_driver','meta_image','meta_description','meta_keywords','meta_title','page_title'];

    protected $casts = ['meta_keywords' => 'array'];

    public function author(){
        return $this->belongsTo(Admin::class, 'author_id');
    }
    public function details()
    {
        return $this->hasOne(BlogDetails::class, 'blog_id');
    }

    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'blog_category_id');
    }
    public static function BlogsCountById ($category_id){
        $categoryCount = Blog::where('category_id', $category_id)->where('status', 1)->count();
        return $categoryCount;
    }

    public function getLanguageEditClass($id, $languageId)
    {
        return DB::table('blog_details')->where(['blog_id' => $id, 'language_id' => $languageId])->exists() ? 'bi-check2' : 'bi-pencil';
    }

    public function getMetaRobots()
    {
        $cleaned = str_replace(['[', ']', '"'], '', $this->meta_robots);

        return explode(",", $cleaned);
    }
    public static function getRecentBlogs($existId = null, $limit = 4)
    {
        $blogs = self::orderBy('created_at', 'desc')
            ->when($existId != null, function ($query) use($existId){
                $query->where('id', '!=', $existId);
            })
            ->limit($limit)->get();
        return $blogs;
    }

}
