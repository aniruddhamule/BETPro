<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function inplayes(){
        return $this->hasMany(Matche::class)->whereStatus(1)->latest()->limit(5);
    }

    public function matches(){
        return $this->hasMany(Matche::class);
    }
    

    public function cat(){
        return $this->belongsTo(Category::class)->withDefault();
    }
}
