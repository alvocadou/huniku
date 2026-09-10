<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('user_type', ['pembeli', 'developer'])->default('pembeli')->after('is_admin');
            $table->string('company_name')->nullable()->after('user_type');
            $table->string('phone')->nullable()->after('company_name');
            $table->string('whatsapp')->nullable()->after('phone');
            $table->string('instagram')->nullable()->after('whatsapp');
            $table->enum('developer_status', ['pending', 'verified', 'rejected'])->nullable()->after('instagram');
            $table->text('developer_rejection_reason')->nullable()->after('developer_status');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'user_type', 'company_name', 'phone', 'whatsapp',
                'instagram', 'developer_status', 'developer_rejection_reason',
            ]);
        });
    }
};