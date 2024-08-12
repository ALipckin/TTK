<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scope extends Model
{
    use HasFactory;

    public function ttk()
    {
        return $this->belongsTo(Ttk::class);
    }
}
