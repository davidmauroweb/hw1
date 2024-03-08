<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHardwareTable extends Migration
{
    public function up()
    {
        Schema::create('hardware', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->smallIncrements('hardware_id');
            $table->string('denomination', 100)->nullable(false);
            $table->string('icon', 50)->nullable(false);
            $table->timestamps();
            $table->boolean('enabled')->nullable(false)->default(1);
        });
    }

    public function down()
    {
        Schema::dropIfExists('hardware');
    }
}
