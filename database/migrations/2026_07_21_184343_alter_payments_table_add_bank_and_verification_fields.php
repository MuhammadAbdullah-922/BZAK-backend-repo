<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Enum columns can't be altered with a plain ->change() unless
        // doctrine/dbal is installed, so we do it with raw SQL — works on
        // MySQL/MariaDB. If you're on PostgreSQL, let me know and I'll
        // give you the equivalent syntax.
        DB::statement("ALTER TABLE payments MODIFY method ENUM('cod','online','card','jazzcash','easypaisa','bank') DEFAULT 'cod'");
     DB::statement("ALTER TABLE payments MODIFY status ENUM('pending','paid','failed','refunded') DEFAULT 'pending'");
        Schema::table('payments', function (Blueprint $table) {
            if (!Schema::hasColumn('payments', 'sender_number')) {
                $table->string('sender_number')->nullable()->after('transaction_id');
            }
            if (!Schema::hasColumn('payments', 'bank_reference')) {
                $table->string('bank_reference')->nullable()->after('sender_number');
            }
            if (!Schema::hasColumn('payments', 'verified_by')) {
                $table->unsignedBigInteger('verified_by')->nullable()->after('status');
            }
            if (!Schema::hasColumn('payments', 'verified_at')) {
                $table->timestamp('verified_at')->nullable()->after('verified_by');
            }
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn(['sender_number', 'bank_reference', 'verified_by', 'verified_at']);
        });

        DB::statement("ALTER TABLE payments MODIFY method ENUM('cod','online','card','jazzcash','easypaisa') DEFAULT 'cod'");
        DB::statement("ALTER TABLE payments MODIFY status ENUM('pending','paid','failed','refunded') DEFAULT 'pending'");
    }
};