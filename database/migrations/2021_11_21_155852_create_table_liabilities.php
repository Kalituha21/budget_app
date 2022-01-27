<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableLiabilities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('liabilities', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->float('amount', 18, 8);
            $table->string('currency', 3)->default('eur');
            $table->bigInteger('liability_expense_rule_id')->nullable();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('liabilities');
    }
}
