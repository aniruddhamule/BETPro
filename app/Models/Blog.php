<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function blog_cat(){
        return $this->belongsTo(BlogCategory::class)->withDefault();
    }

    public function admin(){
        return $this->belongsTo(Admin::class,'id');
    }
}
