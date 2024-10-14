<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create( 'leave_table_details', function ( Blueprint $table ) {
            $table->id();
            $table->unsignedBigInteger( 'leave_table_id' )->nullable();
            $table->integer( 'leave_type_id' )->nullable();
            $table->decimal( 'from' )->nullable();
            $table->decimal( 'to' )->nullable();
            $table->decimal( 'entitlement' )->nullable();
            $table->decimal( 'carried_forward' )->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign( 'leave_table_id' )->references( 'id' )->on( 'leave_tables' )->onDelete( 'cascade' );
        } );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists( 'leave_table_details' );
    }
};
