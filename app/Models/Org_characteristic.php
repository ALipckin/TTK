<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Org_characteristic extends Model
{
    use HasFactory;
    public $timestamps = false;
    public function ttks()
    {
        return $this->hasMany(ttk::class);
    }
}
