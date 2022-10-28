<?php

namespace App\Models;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Overtime extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'overtimes';
    protected $fillable = [
        'id',
        'employee_id',
        'date',
        'time_started',
        'time_ended'
    ];

    public function employees()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}
