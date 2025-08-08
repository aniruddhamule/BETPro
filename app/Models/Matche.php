<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Matche extends Model
{
    use HasFactory;
    
    protected $guarded = ['id'];

    public function event(){
        return $this->belongsTo(Event::class);
    }

    public function cat()
    {
        return $this->belongsTo(Category::class);
    }

    public function questions(){
        return $this->hasMany(BetQuestion::class,'match_id');
    }

    public function questionsEndTime()
    {
        $now = Carbon::now();
        return $this->hasMany(BetQuestion::class,'match_id')->whereStatus(1)->where('end_time','>=', $now);
    }

    public function options()
    {
        return $this->hasMany(BetOption::class,'match_id');
    }

    public function betInvests()
    {
        return $this->hasMany(BetInvest::class,'match_id');
    }

    public function totalBetInvests()
    {
        return $this->hasMany(BetInvest::class,'match_id')->where('status','!=',2)->sum('invest_amount');
    }

    public function scopeRunningMatch()
    {
        return $this->where('start_date', '<=', now())->where('end_date', '>=', now());
    }

    public function scopeUpcomingMatch()
    {
        return $this->where('start_date', '>=', Carbon::now());
    }

    public function scopeCompletedMatch()
    {
        return $this->where('end_date', '<', Carbon::now());
    }

    public function scopeRunningForMatch()
    {
        return $this->where('status', 1)
        ->whereHas('cat', function($q) {
            $q->where('status', 1);
        })->whereHas('event', function($query) {
            $query->where('status', 1);
        })->where('start_date', '<=', now())->where('end_date', '>=', now());
    }
}
