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
            $table->foreignId('email_id')->comment('Идентификатор почтового адреса из таблицы emails');
            $table->foreignId('rubric_id')->comment('идентификатор рубрики из таблицы rubrics');
            $table->timestamp('subscribed_at' ,0)->comment('Дата, когда была выполнена подписка на данную рубрику');
            $table->primary(['email_id', 'rubric_id']);
            $table->foreign('email_id')->references('id')->on('emails')->onDelete('cascade');
            $table->foreign('rubric_id')->references('id')->on('rubrics')->onDelete('cascade');
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
