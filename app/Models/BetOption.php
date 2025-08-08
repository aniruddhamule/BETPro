<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BetOption extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function question()
    {
        return $this->belongsTo(BetQuestion::class,'question_id','id');
    }
    public function invests()
    {
        return $this->hasMany(BetInvest::class, 'betoption_id');
    }

    public function match()
    {
        return $this->belongsTo(Matche::class);
    }

    public function investAmo()
    {
        return $this->hasMany(BetInvest::class, 'betoption_id')->where('status','!=',2)->sum('invest_amount');
    }

    public function giveBackAmo()
    {
        return $this->hasMany(BetInvest::class, 'betoption_id')->where('status','!=',2)->sum('return_amount');
    }

    public function scopeTotalInvestByOptions()
    {
        return $this->hasMany(BetInvest::class,'betoption_id')->where('status','!=',2)->count();
    }
}
