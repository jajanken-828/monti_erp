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
        Schema::table('users', function (Blueprint $table) {
            // Add more role/position related fields if needed
            $table->string('department')->nullable()->after('position');
            $table->string('employee_id')->unique()->nullable()->after('department');
            $table->date('join_date')->nullable()->after('employee_id');
            $table->boolean('is_active')->default(true)->after('join_date');
        });

        // Create user permissions table if you need advanced permissions
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('role_permissions', function (Blueprint $table) {
            $table->id();
            $table->string('role'); // HRM, SCM
            $table->string('position'); // manager, staff
            $table->foreignId('permission_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            $table->unique(['role', 'position', 'permission_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_permissions');
        Schema::dropIfExists('permissions');

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['department', 'employee_id', 'join_date', 'is_active']);
        });
    }
};
