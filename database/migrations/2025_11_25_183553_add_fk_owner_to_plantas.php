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
        Schema::table('plantas', function (Blueprint $table) {
            $table->foreignId('owner')
                ->constrained('users')
                ->onDelete('cascade')
                ->after('id');
        });
    }

    public function down(): void
    {
        Schema::table('plantas', function (Blueprint $table) {
            $table->dropForeign(['owner']);
            $table->dropColumn('owner');
        });
    }

};
