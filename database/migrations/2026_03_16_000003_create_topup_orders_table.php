<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('topup_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('order_code')->unique();
            $table->string('game_slug');
            $table->string('game_name');
            $table->string('player_id');
            $table->string('server_id')->nullable();
            $table->string('package_id');
            $table->string('package_name');
            $table->unsignedBigInteger('package_price');
            $table->string('payment_method');
            $table->string('contact_type');
            $table->string('contact_value');
            $table->string('status')->default('pending');
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'game_slug']);
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('topup_orders');
    }
};
