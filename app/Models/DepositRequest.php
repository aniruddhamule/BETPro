<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepositRequest extends Model
{
    use HasFactory;
    protected $table = 'deposit_requests';
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }

    public function gateway() {
        return $this->belongsTo(PaymentGateway::class,'gateway_id')->withDefault();
    }

    public function deposit_table() {
        return $this->belongsTo(Deposit::class,'deposit_id')->withDefault();
    }
}
