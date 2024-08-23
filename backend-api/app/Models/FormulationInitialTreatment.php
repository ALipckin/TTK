<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormulationInitialTreatment extends Model
{
    use HasFactory;

    protected $table = 'formulations_has_initial_treatments';

    public $timestamps = false;

    public function initialTreatment()
    {
        return $this->belongsTo(InitialTreatment::class);
    }
}
