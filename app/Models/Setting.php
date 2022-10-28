<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    public $timestamps = false;
    
    protected $primaryKey = null;
    public $incrementing = false;
    protected $table = 'settings';
    protected $fillable = [
        'key',
        'value'
    ];
}
