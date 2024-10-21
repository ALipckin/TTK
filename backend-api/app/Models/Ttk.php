<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ttk extends Model
{
    use HasFactory;
    use Filterable;

    protected $fillable = ['image', 'category_id', 'name', 'public', 'isDraft', 'user_id'];
    public $timestamps = false;

    public function category()
    {
        return $this->belongsTo(TtkCategory::class);
    }

    //Заголовок
    public function header()
    {
        return $this->hasOne(Header::class);
    }

    //Область применения
    public function scopes()
    {
        return $this->hasMany(Scope::class);
    }

    //Требования к подаче и реализации
    public function realizationRequirements()
    {
        return $this->hasMany(RealizationRequirement::class);
    }

    //Требования к качеству сырья
    public function qualityRequirements()
    {
        return $this->hasMany(QualityRequirement::class);
    }

    //Рецептуры
    public function formulations()
    {
        return $this->hasMany(Formulation::class);
    }

    //Описание технологического процесса
    public function Tps()
    {
        return $this->hasMany(Tp::class);
    }

    // Органолептические показатели
    public function orgCharacteristics()
    {
        return $this->hasOne(OrgCharacteristic::class);
    }


    // Получить все связанные комментарии и вложения
    public function getAllRelatedRecords()
    {
        return [
            'headers' => $this->headers()->get(),
            'scopes' => $this->scopes()->get(),
            'quality_requirements' => $this->qualityRequirements()->get(),
            'formulations' => $this->formulations()->get(),
            'tps' => $this->tps()->get(),
            'realization_requirements' => $this->realizationRequirements()->get(),
            'org_characteristics' => $this->orgCharacteristics()->get(),
        ];
    }
}

