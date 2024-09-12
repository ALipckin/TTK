<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formulation extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['brutto', 'netto', 'product_id', 'package_id', 'ttk_id'];

    public function ttk()
    {
        return $this->belongsTo(Ttk::class);
    }

    public function heatTreatment()
    {
        return $this->belongsToMany(Treatment::class, 'formulations_has_heat_treatments', 'formulation_id', 'heat_treatment_id');
    }

    public function initialTreatment()
    {
        return $this->belongsToMany(InitialTreatment::class, 'formulations_has_initial_treatments', 'formulation_id', 'initial_treatment_id');
    }
}
