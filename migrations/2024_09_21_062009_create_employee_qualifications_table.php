<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create( 'employee_qualifications', function ( Blueprint $table ) {
            $table->id();
            $table->unsignedBigInteger( 'employee_id' )->nullable();
            $table->unsignedBigInteger( 'user_id' )->nullable()->comment( 'this is employee forging key' );
            $table->string( 'employee_unid' )->nullable();
            $table->string( 'q_institution' )->nullable();
            $table->string( 'q_level' )->nullable();
            $table->string( 'q_type' )->nullable();
            $table->string( 'q_start_date' )->nullable();
            $table->string( 'q_end_date' )->nullable();
            $table->string( 'q_expire_date' )->nullable();
            $table->string( 'q_file' )->nullable();
            $table->string( 'q_comment' )->nullable();
            $table->timestamps();
            $table->foreign( 'employee_id' )->references( 'id' )->on( 'employees' )->onDelete( 'cascade' );
            $table->foreign( 'user_id' )->references( 'id' )->on( 'users' )->onDelete( 'cascade' );
        } );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists( 'employee_qualifications' );
    }
};
