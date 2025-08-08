<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Support extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function support_comment() {
        return $this->hasMany(SupportComment::class, 'ticket_id', 'ticket');
    }

    public function user_member() {
        return $this->hasOne(User::class, 'id', 'user_id')->withDefault();
    }

    public function admin() {
        return $this->hasOne(Admin::class, 'id');
    }
}
