<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formulation extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['brutto', 'netto', 'product_id', 'ttk_id'];

    public function ttk()
    {
        return $this->belongsTo(Ttk::class);
    }

    public function treatment()
    {
        return $this->belongsTo(Treatment::class);
    }

    public function getPortionNettoGrams($ttk_id)
    {
        $formulations = Formulation::where('ttk_id', $ttk_id)->get();
        $portionGrams = 0;
        foreach ($formulations as $key => $formulation) {
            $portionGrams += $formulation->netto;
        }
        return $portionGrams;
    }
}
