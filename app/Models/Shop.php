<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Shop extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'ssm_no', 'phone', 'address', 'city', 'state', 'country', 'email'];

    public function user()
    {
        return $this->belongsTo(User::class); //inventory belong to user
    }
}
