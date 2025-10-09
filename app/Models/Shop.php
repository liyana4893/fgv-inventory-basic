<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    
    
    protected $fillable = ['name', 'ssm_no', 'phone', 'address', 'city', 'state', 'country', 'email'];
    //
    
    public function user()
    {
        return $this->belongsTo(User::class); //inventory belong to user
    }
}
