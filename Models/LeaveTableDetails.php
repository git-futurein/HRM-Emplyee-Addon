<?php

namespace Addons\Employee\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeaveTableDetails extends Model {
    use HasFactory, SoftDeletes;

    protected $fillable = ['leave_table_id', 'leave_type_id', 'from', 'to', 'entitlement', 'carried_forward'];

    public function leaveTable() {
        return $this->belongsTo( LeaveTable::class );
    }
}
