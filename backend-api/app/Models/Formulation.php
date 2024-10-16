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
}
