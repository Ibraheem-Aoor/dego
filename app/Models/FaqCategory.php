<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class FaqCategory extends Model
{
    use HasFactory;
    protected $fillable = ['id','title','target','language_id','tab_id'];

    public function faq(){
        return $this->hasMany(Faq::class, 'faq_category');
    }

    public function details()
    {
        return $this->hasOne(FaqCategoryDetails::class, 'category_id');
    }

    public function getLanguageEditClass($id, $languageId)
    {
        return DB::table('faq_category_details')->where(['category_id' => $id, 'language_id' => $languageId])->exists() ? 'bi-check2' : 'bi-pencil';
    }
}
