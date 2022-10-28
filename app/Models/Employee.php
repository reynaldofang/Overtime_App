<?php

namespace App\Models;

use App\Models\Overtime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'employees';
    protected $fillable = [
        'id',
        'name',
        'salary'
    ];

    public function overtimes()
    {
        return $this->hasMany(Overtime::class, 'employee_id');
    }
}
