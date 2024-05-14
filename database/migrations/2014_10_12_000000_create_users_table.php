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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->longText('company_ids')->nullable();
            $table->string('branch_name')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('role')->default('employees');
            $table->string('status')->default('active');
            $table->integer('added_by')->default(0);
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
        });

        \Illuminate\Support\Facades\DB::table('users')->insert([
            'name' => 'Super Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('123456'),
            'status' =>'active',
            'role' => 'super_admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
