<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id()->index();
            $table->string('first_name')->index()->nullable(false);
            $table->string('last_name')->index()->nullable(false);
            $table->string('email')->nullable(false);
            $table->string('sin', 20, 4)->unique()->nullable(false);
            $table->date('sin_expiry_date')->nullable();
            $table->double('hourly_wage_rate', 20, 4)->nullable(false);
            $table->timestamps();
            $table->softDeletes('deleted_at');

            $table->index(['first_name', 'last_name']);
            $table->index('created_at');
            $table->index('updated_at');
            $table->index('deleted_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
