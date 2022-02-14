<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeClocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_clocks', function (Blueprint $table) {
            $table->id()->index();
            $table->foreignId('employees_id')->constrained()->restrictOnUpdate('restrict')->onDelete('restrict');
            $table->dateTime('in')->index();
            $table->dateTime('out')->nullable(true)->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_clocks');
    }
}
