<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComponentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('components', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->bigIncrements('component_id');
            $table->smallInteger('hardware_id')->unsigned()->nullable(false);
            $table->integer('device_id')->unsigned()->nullable(false);
            $table->integer('user_id')->unsigned()->nullable(false);
            $table->string('trademark', 100)->nullable(false);
            $table->string('features', 100)->nullable(false);
            $table->boolean('original')->nullable(false)->default(1);
            $table->date('acquired')->nullable(false);
            $table->date('date_of_expiry')->nullable(true);
            $table->boolean('low')->nullable(false)->default(0);
            $table->date('discharge_date')->nullable(true);
            $table->decimal('amount', $precision = 8, $scale = 2)->nullable();
            $table->timestamps();
            $table->foreign('hardware_id')->references('hardware_id')->on('hardware')->onDelete('cascade');
            $table->foreign('device_id')->references('device_id')->on('devices')->onDelete('cascade');
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');     
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('components');
    }
}
