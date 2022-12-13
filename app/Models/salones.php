<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class salones extends Model
{
    use HasFactory;
    protected $table="salones";

    public function sensores()
    {
        return $this->hasMany(sensores::class);
    }

    public function users()
    {
        return $this->hasMany(usuario::class);
    }
}
