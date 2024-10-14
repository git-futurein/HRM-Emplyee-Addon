<?php

namespace Addons\Employee\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkDaysTable extends Model {
    use HasFactory, SoftDeletes;

    protected $fillable = ['work_table_id', 'day', 'working_time_from', 'working_time_to', 'break_time_from', 'break_time_to'];

    public function work_table() {
        return $this->belongsTo( WorkTable::class );
    }
}
