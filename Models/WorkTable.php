<?php

namespace Addons\Employee\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkTable extends Model {
    use HasFactory, SoftDeletes;

    protected $fillable = ['title', 'daily_working_hours', 'remarks'];

    public function work_days() {
        return $this->hasMany( WorkDaysTable::class );
    }
}
