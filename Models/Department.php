<?php

namespace Addons\Employee\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model {
    use HasFactory, SoftDeletes;

    public function employees() {
        return $this->hasMany( Employee::class, 'department_id' );
    }
}
