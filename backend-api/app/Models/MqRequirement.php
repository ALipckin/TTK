<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MqRequirement extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable=['description', 'ttk_id'];

    public function ttks()
    {
        return $this->hasMany(ttk::class);
    }
}
