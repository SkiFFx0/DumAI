<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('message_histories', function (Blueprint $table)
        {
            $table->id();
            $table->text('content');
            $table->boolean('is_user');
            $table->foreignId('chat_history_id')->nullable()->constrained('chat_histories');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('message_histories');
    }
};
