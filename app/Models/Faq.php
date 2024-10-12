<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Faq extends Model
{
    use HasFactory;
    protected $fillable = ['id','faq_category'];

    public function category(){
        return $this->belongsTo(FaqCategory::class,'faq_category');
    }
    public function details()
    {
        return $this->hasOne(FaqDetails::class, 'faq_id');
    }

    public function getLanguageEditClass($id, $languageId)
    {
        return DB::table('faq_details')->where(['faq_id' => $id, 'language_id' => $languageId])->exists() ? 'bi-check2' : 'bi-pencil';
    }
}
