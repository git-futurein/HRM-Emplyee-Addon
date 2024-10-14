<?php

namespace Addons\Employee\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeaveTable extends Model {
    use HasFactory, SoftDeletes;

    protected $fillable = ['title', 'description'];

    public function leaveTableDetails() {
        return $this->hasMany( LeaveTableDetails::class );
    }
}
