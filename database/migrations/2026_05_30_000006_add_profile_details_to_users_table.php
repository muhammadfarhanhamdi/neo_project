<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'phone_number')) {
                $table->string('phone_number')->nullable()->after('role');
            }

            if (!Schema::hasColumn('users', 'address')) {
                $table->text('address')->nullable()->after('phone_number');
            }

            if (!Schema::hasColumn('users', 'city')) {
                $table->string('city')->nullable()->after('address');
            }

            if (!Schema::hasColumn('users', 'birth_date')) {
                $table->date('birth_date')->nullable()->after('city');
            }

            if (!Schema::hasColumn('users', 'gender')) {
                $table->string('gender', 20)->nullable()->after('birth_date');
            }

            if (Schema::hasColumn('users', 'github_id')) {
                $table->dropColumn('github_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'github_id')) {
                $table->string('github_id')->nullable()->after('role');
            }

            if (Schema::hasColumn('users', 'gender')) {
                $table->dropColumn('gender');
            }

            if (Schema::hasColumn('users', 'birth_date')) {
                $table->dropColumn('birth_date');
            }

            if (Schema::hasColumn('users', 'city')) {
                $table->dropColumn('city');
            }

            if (Schema::hasColumn('users', 'address')) {
                $table->dropColumn('address');
            }

            if (Schema::hasColumn('users', 'phone_number')) {
                $table->dropColumn('phone_number');
            }
        });
    }
};