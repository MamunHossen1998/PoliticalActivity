<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->unsignedTinyInteger('is_active')->default(1)->after('guard_name');
            $table->string('route_segment', 50)->default('admin')->after('guard_name')->comment('ex: agent');
        });
    }

    public function down(): void
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->dropColumn('is_active');
            $table->dropColumn('route_segment');
        });
    }
};
