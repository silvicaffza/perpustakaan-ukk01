<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('loans', function (Blueprint $table) {
            $table->timestamp('pickup_deadline')->nullable();
            $table->timestamp('return_requested_at')->nullable()->after('due_date');
            $table->text('rejection_reason')->nullable()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('loans', function (Blueprint $table) {
            $table->dropColumn([
                'pickup_deadline',
                'return_requested_at',
                'rejection_reason'
            ]);
        });
    }
};
