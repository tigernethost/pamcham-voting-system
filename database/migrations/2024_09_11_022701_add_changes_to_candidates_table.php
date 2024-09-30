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
        Schema::table('candidates', function (Blueprint $table) {
            $table->renameColumn('description', 'position');
            $table->string('position')->change();
            $table->string('email_address')->after('position');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('candidates', function (Blueprint $table) {
            // Change 'position' column back to 'text'
            $table->text('position')->change();

            // Rename 'position' column back to 'description'
            $table->renameColumn('position', 'description');

            // Drop the 'email_address' column
            $table->dropColumn('email_address');
        });
    }
};
