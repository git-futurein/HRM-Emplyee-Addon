<?php

namespace Addons\Employee\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model {
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id'];

    public function department() {
        return $this->belongsTo( Department::class );
    }

    public function designation() {
        return $this->belongsTo( Designation::class );
    }

    public function jobCategory() {
        return $this->belongsTo( JobCategory::class );
    }

    public function jobType() {
        return $this->belongsTo( JobType::class );
    }

    public function user() {
        return $this->belongsTo( User::class );
    }

    public function qualifications() {
        return $this->hasMany( EmployeeQualification::class );
    }

    public function documents() {
        return $this->hasMany( EmployeeDocument::class );
    }

    public function contacts() {
        return $this->hasMany( EmployeeContact::class );
    }

    public function provident_fund() {
        return $this->belongsTo( ProvidentFund::class );
    }
}
