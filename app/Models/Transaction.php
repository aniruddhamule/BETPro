<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $appends = ['title','trx','main_amo','charge'];

    public function getTitleAttribute(){
        return $this->description;
    }

    public function getTrxAttribute(){
        return $this->trans_id;
    }

    public function getMainAmoAttribute(){
        return $this->old_bal;
    }

    public function getChargeAttribute(){
        return '0';
    }

    public function user(){
    	return $this->belongsTo(User::class,'user_id','id');
    }
}
