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
        Schema::table('branches', function (Blueprint $table) {
            $table->string('address')->nullable()->after('name');
            $table->string('mnemonic')->nullable()->after('address');
            $table->string('customer_company')->nullable()->after('mnemonic');
            $table->string('customer_mnemonic')->nullable()->after('customer_company');
            $table->string('company_group')->nullable()->after('customer_mnemonic');
            $table->string('curr_no')->nullable()->after('company_group');
            $table->string('co_code')->nullable()->after('curr_no');
            $table->boolean('l_vendor_atm')->default(false)->after('co_code');
            $table->boolean('l_vendor_cpc')->default(false)->after('l_vendor_atm');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('branches', function (Blueprint $table) {
            $table->dropColumn([
                'address',
                'mnemonic',
                'customer_company',
                'customer_mnemonic',
                'company_group',
                'curr_no',
                'co_code',
                'l_vendor_atm',
                'l_vendor_cpc'
            ]);
        });
    }
};
