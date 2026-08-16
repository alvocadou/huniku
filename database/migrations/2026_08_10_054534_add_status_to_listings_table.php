<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('listings', function (Blueprint $table) {
            // default 'approved' biar listing yang udah ada (dibuat admin) tetap tayang tanpa perlu di-backfill
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('approved')->after('is_featured');
            $table->foreignId('submitted_by')->nullable()->after('status')->constrained('users')->nullOnDelete();
            $table->text('rejection_reason')->nullable()->after('submitted_by');
        });
    }

    public function down(): void
    {
        Schema::table('listings', function (Blueprint $table) {
            $table->dropConstrainedForeignId('submitted_by');
            $table->dropColumn(['status', 'rejection_reason']);
        });
    }
};