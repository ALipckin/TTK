<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ttk extends Model
{
    use HasFactory;

    protected $fillable=['image'];
    public $timestamps = false;
    
    public function form()
    {
        return $this->belongsTo(Form::class);
    }
    public function formulations()
    {
        return $this->belongsTo(Form::class);
    }
    public function headers()
    {
        return $this->belongsTo(Form::class, 'id', 'ttks_id')->withDefault();
    }
    public function requirements()
    {
        return $this->belongsTo(Form::class);
    }
    public function tps()
    {
        return $this->belongsTo(Form::class);
    }
}

