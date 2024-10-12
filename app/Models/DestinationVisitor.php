<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DestinationVisitor extends Model
{
    use HasFactory;

    protected $fillable = ['id','device','os','browser_info','bouncing_time','destnation_id','ip_address'];

    public function Destination()
    {
        return $this->belongsTo(Destination::class, 'destination_id');
    }
}
