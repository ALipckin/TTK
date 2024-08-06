<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Header extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable=[
        'company', 'ttk_id', 'property', 'position', 'approver', 'card',
        'created_date', 'dish', 'dev', 'approver2', 'approver2_position'];
        
    public function ttks()
    {
        return $this->hasMany(ttk::class);
    }
}
