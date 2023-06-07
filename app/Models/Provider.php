<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function dealers()
    {
        return $this->hasMany(Dealer::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

}
