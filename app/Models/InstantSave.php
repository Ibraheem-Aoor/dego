<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstantSave extends Model
{
    use HasFactory;

    protected  $fillable =['id','address_two','postal_code','city','state','country','message','cupon_status','cupon_code','discount_amount','total_price','total_gross','date','fname','lname','email','phone','phone','address_one','package_id','user_id','deposit_id','total_children','total_adult','total_infant'];
}
