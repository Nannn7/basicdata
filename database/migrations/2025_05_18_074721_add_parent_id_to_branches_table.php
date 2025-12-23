<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('branches', function (Blueprint $table) {
            // Tambah kolom parent_id jika belum ada
            if (!Schema::hasColumn('branches', 'parent_id')) {
                $table->unsignedBigInteger('parent_id')->nullable()->after('name');
            }
        });

        // Tambah foreign key jika belum ada
        if (!$this->foreignKeyExists('branches', 'branches_parent_id_foreign')) {
            Schema::table('branches', function (Blueprint $table) {
                $table->foreign('parent_id', 'branches_parent_id_foreign')
                    ->references('id')
                    ->on('branches')
                    ->onDelete('set null');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop foreign key jika ada
        if ($this->foreignKeyExists('branches', 'branches_parent_id_foreign')) {
            Schema::table('branches', function (Blueprint $table) {
                $table->dropForeign('branches_parent_id_foreign');
            });
        }

        // Drop kolom jika ada
        Schema::table('branches', function (Blueprint $table) {
            if (Schema::hasColumn('branches', 'parent_id')) {
                $table->dropColumn('parent_id');
            }
        });
    }

    /**
     * Cek apakah foreign key exists
     */
    private function foreignKeyExists(string $table, string $name): bool
    {
        $conn = Schema::getConnection();
        $dbName = $conn->getDatabaseName();

        $result = DB::select(
            "SELECT CONSTRAINT_NAME
             FROM information_schema.TABLE_CONSTRAINTS
             WHERE TABLE_SCHEMA = ?
             AND TABLE_NAME = ?
             AND CONSTRAINT_NAME = ?
             AND CONSTRAINT_TYPE = 'FOREIGN KEY'",
            [$dbName, $table, $name]
        );

        return count($result) > 0;
    }
};
