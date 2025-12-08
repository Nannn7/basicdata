<?php

    namespace Modules\Basicdata\Models;

    class Branch extends Base
    {
        protected $table    = 'branches';
        protected $fillable = [
            'code',
            'name',
            'is_dalam_kota',
            'address',
            'mnemonic',
            'customer_company',
            'customer_mnemonic',
            'company_group',
            'curr_no',
            'co_code',
            'l_vendor_atm',
            'l_vendor_cpc',
            'status',
            'authorized_at',
            'authorized_status',
            'authorized_by',
            'parent_id'
        ];

        /**
         * Get the parent branch of this branch
         */
        public function parent()
        {
            return $this->belongsTo(Branch::class, 'parent_id');
        }

        /**
         * Get the child branches of this branch
         */
        public function children()
        {
            return $this->hasMany(Branch::class, 'parent_id');
        }
    }
