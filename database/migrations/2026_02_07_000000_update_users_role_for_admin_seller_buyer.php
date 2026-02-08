<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Updates role column to support admin, seller, buyer.
     * Converts legacy 'user' to 'buyer'.
     *
     * @return void
     */
    public function up()
    {
        // Convert existing 'user' role to 'buyer' for compatibility
        DB::table('users')->where('role', 'user')->orWhereNull('role')->update(['role' => 'buyer']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('users')->where('role', 'buyer')->update(['role' => 'user']);
    }
};
