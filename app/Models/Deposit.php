<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    use HasFactory;
    protected $table = 'deposits';
    protected $guarded = ['id'];

    protected $appends = ['is_manual'];

    public function getIsManualAttribute(){
        if(!empty($this->deposit_request_table)){
            $result = 1;
        }else{
            $result = 0;;
        }
        return $result;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }

    public function deposit_request_table()
    {
        return $this->hasOne(DepositRequest::class,'deposit_id');
    }

    public function gateway() {
        return $this->belongsTo(PaymentGateway::class,'gateway_id')->withDefault();
    }
}
