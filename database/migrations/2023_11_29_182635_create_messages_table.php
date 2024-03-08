<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->bigIncrements('message_id');
            $table->integer('user_id')->unsigned()->nullable(false);
            $table->smallInteger('template_id')->unsigned()->nullable(false);
            $table->string('subject', 100)->nullable(false);
            $table->string('title', 100)->nullable(true);
            $table->string('header', 500)->nullable(true);
            $table->string('body', 2500)->nullable(true);
            $table->string('footer', 500)->nullable(true);
            $table->string('logo', 100)->nullable(true);
            $table->string('sender', 100)->nullable(false);
            $table->string('button', 50)->nullable(false);
            $table->timestamps();
            $table->foreign('user_id')->references('user_id')->on('users');
            $table->foreign('template_id')->references('template_id')->on('templates');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
}
