<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Panier
{
    public $plats = null;
    public $prixTotal = 0;
    public $qteTotal = 0;

    public function __construct($panier){
        if($panier){
            $this->plats = $panier->plats;
            $this->prixTotal = $panier->prixTotal;
            $this->qteTotal = $panier->qteTotal;
        }
    }

    public function addPlat($plat, $id){
         $platTemp = [
            'qte' => 0,
            'prix' => 0,
            'plat' => $plat
        ];

        if($this->plats){
            if(array_key_exists($plat->id, $this->plats)){
                $platTemp = $this->plats[$plat->id];
            }
        }

        $platTemp['qte']++;
        $platTemp['prix'] = $plat->prix * $platTemp['qte'];
        $this->qteTotal++;
        $this->prixTotal += $plat->prix;
        $this->plats[$plat->id] = $platTemp;
    }
}
