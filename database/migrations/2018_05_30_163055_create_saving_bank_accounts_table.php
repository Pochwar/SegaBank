<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSavingBankAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saving_bank_accounts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('account_code')->unsigned()->unique();
            $table->integer('tx_interet');

            $table->timestamps();

            $table->foreign('account_code')->references('code')->on('bank_accounts')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('saving_bank_accounts');
    }
}
