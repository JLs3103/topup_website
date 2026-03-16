<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('topup_orders', function (Blueprint $table): void {
            $table->string('payment_proof_path')->nullable()->after('contact_value');
            $table->text('payment_notes')->nullable()->after('payment_proof_path');
            $table->timestamp('paid_at')->nullable()->after('payment_notes');
        });

        Schema::table('users', function (Blueprint $table): void {
            $table->boolean('is_admin')->default(false)->after('password');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->dropColumn('is_admin');
        });

        Schema::table('topup_orders', function (Blueprint $table): void {
            $table->dropColumn(['payment_proof_path', 'payment_notes', 'paid_at']);
        });
    }
};
