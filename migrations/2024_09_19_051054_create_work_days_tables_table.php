<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create( 'work_days_tables', function ( Blueprint $table ) {
            $table->id();
            $table->unsignedBigInteger( 'work_table_id' );
            $table->enum( 'day_of_week', ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] );
            $table->string( 'working_day' )->nullable();
            $table->time( 'working_time_from' )->nullable();
            $table->time( 'working_time_to' )->nullable();
            $table->time( 'break_time_from' )->nullable();
            $table->time( 'break_time_to' )->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign( 'work_table_id' )
                ->references( 'id' )
                ->on( 'work_tables' )
                ->onDelete( 'cascade' );

        } );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists( 'work_days_tables' );
    }
};
