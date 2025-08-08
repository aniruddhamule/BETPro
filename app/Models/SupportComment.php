<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportComment extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function support() {
        return $this->belongsTo(Support::class);
    }
    
}
