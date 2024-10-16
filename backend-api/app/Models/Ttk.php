<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ttk extends Model
{
    use HasFactory;
    use Filterable;

    protected $fillable = ['image'];
    public $timestamps = false;

    public function headers()
    {
        return $this->hasMany(Header::class);
    }

    public function scopes()
    {
        return $this->hasMany(Scope::class);
    }

    public function qualityRequirements()
    {
        return $this->hasMany(QualityRequirement::class);
    }

    public function formulations()
    {
        return $this->hasMany(Formulation::class);
    }

    public function Tps()
    {
        return $this->hasMany(Tp::class);
    }

    public function realizationRequirement()
    {
        return $this->hasMany(RealizationRequirement::class);
    }

    public function orgCharacteristics()
    {
        return $this->hasMany(OrgCharacteristic::class)->first();
    }

    public function formulationHeatTreatment()
    {
        return $this->hasMany(FormulationHeatTreatment::class);
    }

    // Получить все связанные комментарии и вложения
    public function getAllRelatedRecords($type)
    {
        return [
            'headers' => $this->headers()->get(),
            'scopes' => $this->scopes()->get(),
            'quality_requirements' => $this->qualityRequirements()->get(),
            'formulations' => $this->formulations()->get(),
            'tps' => $this->tps()->get(),
            'realization_requirements' => $this->realizationRequirement()->get(),
            'org_characteristics' => $this->orgCharacteristics()->get(),
            'formulation_has_heat_treatments' => $this->formulationHeatTreatment()->get(),
        ];
    }
}

