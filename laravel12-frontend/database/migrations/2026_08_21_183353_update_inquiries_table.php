<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('inquiries', function (Blueprint $table) {
            $table->string('reference_number')->unique()->nullable()->after('id');
            $table->string('subject')->nullable()->after('message');
            $table->unsignedBigInteger('category_id')->nullable()->after('subject');
            $table->string('attachment')->nullable()->after('category_id');
            $table->string('status')->default('pending')->after('attachment');
            $table->string('priority')->default('medium')->after('status');
            $table->string('tracking_token')->unique()->nullable()->after('priority');
            $table->foreign('category_id')->references('id')->on('categories')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('inquiries', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn([
                'reference_number',
                'subject',
                'category_id',
                'attachment',
                'status',
                'priority',
                'tracking_token',
            ]);
        });
    }
};
