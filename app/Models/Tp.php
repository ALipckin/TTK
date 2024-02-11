<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tp extends Model
{
    use HasFactory;
    public $timestamps = false;
    public function ttks()
    {
        return $this->hasMany(ttk::class);
    }
}
