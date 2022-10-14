<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vk_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->index()->constrained('user')->cascadeOnDelete();
            $table->bigInteger('vk_id');
            $table->string('access_token', 1024);
            $table->string('email', 500)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vk_user');
    }
};
