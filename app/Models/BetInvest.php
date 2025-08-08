<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BetInvest extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
    public function match()
    {
        return $this->belongsTo(Matche::class,'match_id','id');
    }
    public function ques()
    {
        return $this->belongsTo(BetQuestion::class,'betquestion_id','id');
    }
    public function betoption()
    {
        return $this->belongsTo(BetOption::class,'betoption_id','id');
    }

    public function scopePending()
    {
        return $this->where('status', 0);
    }

    public function scopeWon()
    {
        return $this->where('status', 1);
    }

    public function scopeLose()
    {
        return $this->where('status', -1);
    }

    public function scopeRefunded()
    {
        return $this->where('status', 2);
    }
}
