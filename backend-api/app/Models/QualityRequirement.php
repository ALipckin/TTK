<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QualityRequirement extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $guarded = [];
    protected $fillable=['description', 'ttk_id'];

    public function ttk()
    {
        return $this->belongsTo(Ttk::class);
    }
}
