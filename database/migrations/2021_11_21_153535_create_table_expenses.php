<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableExpenses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->float('amount', 18, 8);
            $table->string('currency', 3)->default('eur');
            $table->string('every', 10)->default('month');
            $table->timestamp('created_at')->default('CURRENT_TIMESTAMP');
            $table->timestamp('delete_at')->nullable();

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
        Schema::dropIfExists('expenses');
    }
}
