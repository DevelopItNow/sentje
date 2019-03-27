<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPaidAndAccountIdToPlannedPayments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('planned_payments', function (Blueprint $table) {
            $table->boolean('paid');
            $table->integer('account_id')->unsigned();
            $table->foreign('account_id')->references('id')->on('bank_accounts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('planned_payments', function (Blueprint $table) {
            //
        });
    }
}
