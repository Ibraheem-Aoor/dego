<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FaqDetails extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function faq(){
        return $this->belongsTo(Faq::class, 'faq_id');
    }
}
