<?php

    namespace Modules\Basicdata\Models;

    class Branch extends Base
    {
        protected $table    = 'branches';
        protected $fillable = ['code', 'name', 'status', 'authorized_at', 'authorized_status', 'authorized_by', 'parent_id'];

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
