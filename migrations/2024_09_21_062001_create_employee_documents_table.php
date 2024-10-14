<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create( 'employee_documents', function ( Blueprint $table ) {
            $table->id();
            $table->unsignedBigInteger( 'employee_id' )->nullable()->comment( 'this is employee forging key' );
            $table->unsignedBigInteger( 'user_id' )->nullable();
            $table->string( 'employee_unid' )->nullable();
            $table->string( 'd_title' )->nullable();
            $table->string( 'd_category' )->nullable();
            $table->string( 'd_start_date' )->nullable();
            $table->string( 'd_end_date' )->nullable();
            $table->string( 'd_expiry_date' )->nullable();
            $table->string( 'd_file' )->nullable();
            $table->string( 'd_remark' )->nullable();
            $table->timestamps();
            $table->foreign( 'employee_id' )->references( 'id' )->on( 'employees' )->onDelete( 'cascade' );
            $table->foreign( 'user_id' )->references( 'id' )->on( 'users' )->onDelete( 'cascade' );
        } );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists( 'employee_documents' );
    }
};
