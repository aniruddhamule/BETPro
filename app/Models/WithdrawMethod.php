<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WithdrawMethod extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    protected $appends = ['image_url'];

    public function getImageUrlAttribute(){
        if(!empty($this->image)){
            $img = asset('public/images/withdraw/'.rawurlencode($this->image));
        }else{
            $img = asset('public/images/no-image.png');
        }
        return $img;
    }

    public function method_log() {
        return $this->hasMany(WithdrawLog::class, 'withdraw_id', 'id');

    }
}
