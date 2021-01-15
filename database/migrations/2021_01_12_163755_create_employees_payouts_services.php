<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesPayoutsServices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees_payouts_services', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('employees_payout_id')->unsigned();
            $table->bigInteger('service_id')->unsigned();
            $table->integer('multiplicity');
            $table->timestamps();
            $table->foreign('employees_payout_id')->references('id')->on('Employees_payouts');
            $table->foreign('service_id')->references('id')->on('Services');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees_payouts_services');
    }
}
