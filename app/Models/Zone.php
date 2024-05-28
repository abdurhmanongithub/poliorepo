<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function woredas()
    {
        return $this->hasMany(Woreda::class);
    }
    public function region()
    {
        return $this->belongsTo(Region::class);
    }
}
