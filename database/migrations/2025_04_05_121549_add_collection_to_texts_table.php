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
        Schema::table('texts', function (Blueprint $table) {
            $table->string('collection')->nullable();
            $table->string('magazine')->nullable();
            $table->json('personification')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('texts', function (Blueprint $table) {
            $table->dropColumn('collection');
            $table->dropColumn('magazine');
            $table->dropColumn('personification');

        });
    }
};
