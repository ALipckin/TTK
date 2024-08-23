<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormulationHeatTreatment extends Model
{
    use HasFactory;

    protected $table = 'formulations_has_heat_treatments';

    public $timestamps = false;

    public function heatTreatment()
    {
        return $this->belongsTo(HeatTreatment::class);
    }
}
