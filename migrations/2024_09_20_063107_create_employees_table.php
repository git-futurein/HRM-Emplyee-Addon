<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create( 'employees', function ( Blueprint $table ) {
            $table->id();
            $table->unsignedBigInteger( 'auth_id' )->nullable();
            $table->foreignId( 'user_id' )->constrained()->onDelete( 'cascade' );
            $table->string( 'name' )->nullable();
            $table->string( 'email' )->nullable();
            $table->string( 'image' )->nullable();
            $table->string( 'employee_id' )->unique()->nullable();
            $table->string( 'id_number' )->unique()->nullable();
            $table->integer( 'id_type_id' )->nullable();
            $table->string( 'dob' )->nullable();
            $table->string( 'gender' )->nullable();
            $table->integer( 'race_id' )->nullable();
            $table->string( 'phone' )->nullable();
            $table->string( 'optional_email' )->nullable();
            $table->string( 'address_type' )->nullable();
            $table->string( 'house_no' )->nullable();
            $table->string( 'level_no' )->nullable();
            $table->string( 'unit_no' )->nullable();
            $table->string( 'street' )->nullable();
            $table->string( 'address' )->nullable();
            $table->string( 'city' )->nullable();
            $table->string( 'state' )->nullable();
            $table->string( 'zip_code' )->nullable();
            $table->integer( 'country_id' )->nullable();
            $table->integer( 'nationality_id' )->nullable();
            $table->string( 'home_telephone' )->nullable();
            $table->string( 'work_telephone' )->nullable();
            $table->string( 'marital_status' )->nullable();
            $table->text( 'comment' )->nullable();
            $table->string( 'bank_name' )->nullable();
            $table->string( 'bank_swift_code' )->nullable();
            $table->string( 'bank_account' )->nullable();
            $table->string( 'role' )->nullable();
            $table->enum( 'is_active', ['active', 'inactive'] )->nullable();
            $table->integer( 'cpf_id' )->nullable();
            $table->enum( 'cpf_full_paid', ['yes', 'no'] )->nullable();
            $table->string( 'pr_effective_date' )->nullable();
            $table->string( 'cpf_no' )->nullable();
            $table->string( 'tax_no' )->nullable();
            $table->integer( 'work_table_id' )->nullable();
            $table->integer( 'leave_table_id' )->nullable();
            $table->string( 'cpf' )->nullable();
            $table->string( 'shg' )->nullable();
            $table->string( 'us_attendance' )->nullable();
            $table->decimal( 'max_pay_calculate' )->default( 0.00 )->nullable();
            $table->decimal( 'food_allowance' )->default( 0.00 )->nullable();
            $table->decimal( 'mobile_allowance' )->default( 0.00 )->nullable();
            $table->decimal( 'ot_allowance' )->default( 0.00 )->nullable();
            $table->decimal( 'trainer_fee_allowance' )->default( 0.00 )->nullable();
            $table->decimal( 'transportation_allowance' )->default( 0.00 )->nullable();
            $table->decimal( 'cdac_deduction' )->default( 0.00 )->nullable();
            $table->decimal( 'ecf_deduction' )->default( 0.00 )->nullable();
            $table->decimal( 'mbmf_deduction' )->default( 0.00 )->nullable();
            $table->decimal( 'sinda_deduction' )->default( 0.00 )->nullable();
            $table->decimal( 'transportation_deduction' )->default( 0.00 )->nullable();
            $table->string( 'job_title' )->nullable();
            $table->integer( 'job_category_id' )->nullable();
            $table->integer( 'designation_id' )->nullable();
            $table->string( 'pay_basis' )->nullable();
            $table->decimal( 'basic_rate' )->default( 0.00 )->nullable();
            $table->string( 'start_date' )->nullable();
            $table->string( 'end_date' )->nullable();
            $table->integer( 'department_id' )->nullable();
            $table->string( 'emplyee_status' )->nullable();
            $table->string( 'join_date' )->nullable();
            $table->string( 'left_date' )->nullable();
            $table->integer( 'employee_type' )->nullable();
            $table->integer( 'manager_id' )->nullable();
            $table->string( 'probation_from' )->nullable();
            $table->string( 'probation_to' )->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign( 'auth_id' )->references( 'id' )->on( 'users' )->onDelete( 'cascade' );
        } );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists( 'employees' );
    }
};
