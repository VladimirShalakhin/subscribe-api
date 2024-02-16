<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('emails', function (Blueprint $table) {
            $table->id()->comment('Идентификатор почтового адреса');
            $table->string('address', 256)->comment('Адрес электронной почты');
            $table->boolean('main')->comment('Является ли данный почтовый адрес основным');
            $table->boolean('verified')->comment('Является ли данный почтовый адрес подтвержденным');
            $table->integer('user_id')->comment('Идентификатор пользователя, которому принадлежит данный почтовый адрес');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emails');
    }
};
