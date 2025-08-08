<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentGateway extends Model
{
    use HasFactory;
    protected $guarded = [''];

    public function deposit()
    {
        return $this->hasMany(Deposit::class,'id','gateway_id');
    }

    protected $appends = ['image_url'];

    public function getImageUrlAttribute(){
        if(!empty($this->image)){
            $img = asset('public/images/gateway/'.rawurlencode($this->image));
        }else{
            $img = asset('public/images/no-image.png');
        }
        return $img;
    }

}
