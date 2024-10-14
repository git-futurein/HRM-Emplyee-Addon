<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create( 'employee_contacts', function ( Blueprint $table ) {
            $table->id();
            $table->unsignedBigInteger( 'employee_id' )->nullable()->comment( 'this is employee forging key' );
            $table->unsignedBigInteger( 'user_id' )->nullable();
            $table->string( 'employee_unid' )->nullable();
            $table->string( 'c_name' )->nullable();
            $table->string( 'c_gender' )->nullable();
            $table->integer( 'c_relationship_id' )->nullable();
            $table->string( 'c_home_telephone' )->nullable();
            $table->string( 'c_mobile' )->nullable();
            $table->string( 'c_work_telephone' )->nullable();
            $table->string( 'c_email' )->nullable();
            $table->timestamps();
            $table->foreign( 'employee_id' )->references( 'id' )->on( 'employees' )->onDelete( 'cascade' );
            $table->foreign( 'user_id' )->references( 'id' )->on( 'users' )->onDelete( 'cascade' );
        } );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists( 'employee_contacts' );
    }
};
