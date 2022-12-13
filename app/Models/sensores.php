<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sensores extends Model
{
    use HasFactory;
    protected $table="sensores";

    public function salones(){
        return $this->belongsTo(salones::class,'id');
    }

}
