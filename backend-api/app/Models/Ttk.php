<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ttk extends Model
{
    use HasFactory;
    use Filterable;
    protected $fillable=['image'];
    public $timestamps = false;

    public function form()
    {
        return $this->belongsTo(Form::class);
    }
    public function headersBelongs()
    {
        return $this->belongsTo(Form::class, 'id', 'ttks_id')->withDefault();
    }
    public function headers()
    {
        return $this->hasMany(Header::class);
    }
    public function formulations()
    {
        return $this->hasMany(Formulation::class);
    }
    public function Requirements()
    {
        return $this->hasMany(Requirement::class);
    }
    public function Mq_requirements()
    {
        return $this->hasMany(MqRequirement::class);
    }
    public function Tps()
    {
        return $this->hasMany(tp::class);
    }
    public function Org_characteristics()
    {
        return $this->hasMany(OrgCharacteristic::class);
    }
}

