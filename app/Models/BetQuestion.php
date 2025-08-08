<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BetQuestion extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function options()
    {
        return $this->hasMany(BetOption::class,'question_id');
    }

    public function match()
    {
        return $this->belongsTo(Matche::class,'match_id');
    }

    public function invests()
    {
        return $this->hasMany(BetInvest::class,'betquestion_id');
    }

    public function scopeTotalInvest()
    {
        return $this->hasMany(BetInvest::class,'betquestion_id')->where('status','!=',2)->count();
    }

    public function scopeTotalInvestor()
    {
        return $this->invests()->count();
    }
}
