<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TtkCategory extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'ttks_categories';

    public function ttks()
    {
        return $this->hasMany(Ttk::class);
    }

}
