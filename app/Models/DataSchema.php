<?php

namespace App\Models;

use Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DataSchema extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function getAttributes(){
        return $this->structure??[];
    }
}
