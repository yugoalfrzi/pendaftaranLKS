<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update existing roles
        // dinsos provinsi -> super_admin
        DB::table('users')
            ->where('role', 'dinsos_provinsi')
            ->update(['role' => 'super_admin']);
        
        // dinsos kabkota -> admin
        DB::table('users')
            ->where('role', 'dinsos_kabkota')
            ->update(['role' => 'admin']);
        
        // Ensure default role is 'user' for LKS
        DB::table('users')
            ->whereNull('role')
            ->orWhere('role', '')
            ->update(['role' => 'user']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert roles back
        DB::table('users')
            ->where('role', 'super_admin')
            ->update(['role' => 'dinsos_provinsi']);
        
        DB::table('users')
            ->where('role', 'admin')
            ->update(['role' => 'dinsos_kabkota']);
    }
};
