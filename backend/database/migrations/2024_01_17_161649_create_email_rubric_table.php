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
        Schema::create('email_rubric', function (Blueprint $table) {
            $table->integer('email_id')->comment('Идентификатор почтового адреса из таблицы emails');
            $table->integer('rubric_id')->comment('Идентификатор рубрики из таблицы rubrics');
            $table->timestamp('confirmed_at', 0)->nullable()->comment('Дата, когда было выполнено подтверждение подписки на данную рубрику');
            $table->primary(['email_id', 'rubric_id']);
            $table->text('token')->nullable()->comment('Токен для подтверждения подписи на рубрику');
            $table->foreign('email_id')->references('id')->on('emails')->onDelete('cascade')->comment('Идентификатор почтового адреса из таблицы emails');
            $table->foreign('rubric_id')->references('id')->on('rubrics')->onDelete('cascade')->comment('идентификатор рубрики из таблицы rubrics');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_rubric');
    }
};
