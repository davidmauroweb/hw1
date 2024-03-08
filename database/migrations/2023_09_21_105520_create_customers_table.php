<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->integerIncrements('customer_id');
            $table->integer('user_id')->unsigned();
            $table->string('business_name', 100)->nullable(false);
            $table->boolean('enabled')->nullable(false)->default(1);
            $table->timestamps();
            $table->foreign('user_id')->references('user_id')->on('users');   
        });
    }

    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
