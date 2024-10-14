<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TtkCategory extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'ttk_categories';

    public function ttks()
    {
        return $this->hasMany(Ttk::class);
    }

    // Определяем отношение для дочерних категорий
    public function children()
    {
        return $this->hasMany(TtkCategory::class, 'parent_id');
    }

    // Также, если нужно, можно добавить отношение к родительской категории
    public function parent()
    {
        return $this->belongsTo(TtkCategory::class, 'parent_id');
    }
}
