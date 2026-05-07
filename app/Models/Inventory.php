<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inventory extends Model
{
    use HasFactory, SoftDeletes; //gune soft delete untuk table inventory column deleted at

    public function user()
    {
        return $this->belongsTo(User::class); //inventory belong to user
    }
}
