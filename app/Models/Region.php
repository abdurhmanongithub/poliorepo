<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $guarded = [];

    use HasFactory;

    public function zones()
    {
        return $this->hasMany(Zone::class);
    }

}
