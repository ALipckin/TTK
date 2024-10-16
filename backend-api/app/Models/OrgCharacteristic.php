<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrgCharacteristic extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['ttk_id', 'view', 'color', 'cons', 'taste'];

    public function ttk()
    {
        return $this->belongsTo(Ttk::class);
    }
}
