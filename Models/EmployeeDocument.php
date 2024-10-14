<?php

namespace Addons\Employee\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeDocument extends Model {
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'employee_unid',
        'user_id',
    ];
}
