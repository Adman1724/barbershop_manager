<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesPayoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees_payouts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('payout_id')->unsigned();
            $table->bigInteger('employee_id')->unsigned();
            $table->integer('holiday');
            $table->double('first_part');
            $table->double('second_part');
            $table->double('lunch_card');
            $table->timestamps();
            $table->foreign('payout_id')->references('id')->on('Payouts');
            $table->foreign('employee_id')->references('id')->on('Employees');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees_payouts');
    }
}
