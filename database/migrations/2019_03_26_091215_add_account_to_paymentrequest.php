<?php

    use Illuminate\Support\Facades\Schema;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Database\Migrations\Migration;

    class AddAccountToPaymentrequest extends Migration
    {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::table('payment_requests', function (Blueprint $table) {
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
            Schema::table('payment_requests', function (Blueprint $table) {
                $table->dropColumn('account_id');
            });
        }
    }
