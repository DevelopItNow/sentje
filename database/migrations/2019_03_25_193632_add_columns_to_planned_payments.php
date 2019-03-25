<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToPlannedPayments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('planned_payments', function (Blueprint $table) {
            $table->integer('sender_id')->unsigned();
            $table->integer('receiver_id')->unsigned();
            $table->string('payment_name');
            $table->string('currency');
            $table->date('planned_date');
            $table->float('amount');
            $table->text('description');
            $table->foreign('sender_id')->references('id')->on('users');
            $table->foreign('receiver_id')->references('id')->on('users');
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
