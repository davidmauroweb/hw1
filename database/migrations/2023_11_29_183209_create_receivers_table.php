<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceiversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receivers', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->integerIncrements('receiver_id');
            $table->bigInteger('message_id')->unsigned()->nullable(false);
            $table->string('email', 100)->nullable(false);
            $table->string('name', 100)->nullable(false);
            $table->string('token', 100)->nullable(false);
            $table->boolean('checked')->nullable(false)->default(0);
            $table->timestamps();
            $table->foreign('message_id')->references('message_id')->on('messages');   
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('receivers');
    }
}
