<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    use HasFactory;

    function plats(){
        return $this->belongsToMany(Plat::class)
                    ->withPivot('qte')
                    ->withTimestamps();
    }
}
