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
        Schema::table('quotes', function (Blueprint $table) {
            $table->string('payment_schedule')->nullable()->after('status'); // '50_percent', '100_percent'
            $table->string('rejection_reason')->nullable()->after('payment_schedule');
            $table->text('rejection_message')->nullable()->after('rejection_reason');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quotes', function (Blueprint $table) {
            $table->dropColumn(['payment_schedule', 'rejection_reason', 'rejection_message']);
        });
    }
};
