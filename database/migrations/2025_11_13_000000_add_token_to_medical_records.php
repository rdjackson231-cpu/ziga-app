<?php
// database/migrations/2025_11_13_000000_add_token_to_medical_records.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('medical_records', function (Blueprint $table) {
            $table->uuid('token')->nullable()->unique()->after('patient_id');
        });
    }
    public function down(): void {
        Schema::table('medical_records', function (Blueprint $table) {
            $table->dropColumn('token');
        });
    }
};
