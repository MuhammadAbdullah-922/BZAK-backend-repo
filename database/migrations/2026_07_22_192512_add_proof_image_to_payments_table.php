<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            if (!Schema::hasColumn('payments', 'proof_image')) {
                // stores the relative storage path, e.g.
                // "payment-proofs/abc123.jpg" — full URL is built on read
                $table->string('proof_image')->nullable()->after('bank_reference');
            }
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn('proof_image');
        });
    }
};