<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function event(){
        return $this->hasMany(Event::class, 'cat_id','id');
    }

    public function matches()
    {
        return $this->hasMany(Matche::class,'cat_id','id');
    }

    public function activeMatch()
    {
        return $this->hasMany(Matche::class,'cat_id')->where('status',1);
    }
}
