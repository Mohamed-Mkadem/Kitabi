<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update existing records where rate is null
        DB::table('books')->whereNull('rate')->update(['rate' => 0]);



        Schema::table('books', function (Blueprint $table) {
            $table->decimal('rate', 3, 2)->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->string('rate')->nullable()->change();
        });
    }
};
