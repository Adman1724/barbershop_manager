<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnplanFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unplan_fees', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('employees_payout_id')->unsigned();
            $table->string('name');
            $table->double('value');
            $table->timestamps();
            $table->foreign('employees_payout_id')->references('id')->on('Employees_payouts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('unplan_fees');
    }
}
