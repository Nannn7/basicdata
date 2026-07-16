<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->string('code', 9)->unique();
            $table->string('name');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->boolean('is_dalam_kota')->default(true);
            $table->string('address')->nullable();
            $table->string('mnemonic')->nullable();
            $table->string('customer_company')->nullable();
            $table->string('customer_mnemonic')->nullable();
            $table->string('company_group')->nullable();
            $table->string('curr_no')->nullable();
            $table->string('co_code')->nullable();
            $table->boolean('l_vendor_atm')->default(false);
            $table->boolean('l_vendor_cpc')->default(false);
            $table->boolean('status')->default(true)->nullable();
            $table->timestamps();
            $table->timestamp('authorized_at')->nullable();
            $table->char('authorized_status', 1)->nullable();
            $table->softDeletes();

            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->unsignedBigInteger('authorized_by')->nullable();

            $table->foreign('parent_id', 'branches_parent_id_foreign')
                ->references('id')
                ->on('branches')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('branches');
        Schema::enableForeignKeyConstraints();
    }
};
