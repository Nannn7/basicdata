<?php

    namespace Modules\Basicdata\Database\Seeders;

    use Illuminate\Database\Seeder;
    use Modules\Usermanagement\Models\PermissionGroup;

    class PermissionSeeder extends Seeder
    {
        /**
         * Run the database seeds.
         */
        public function run(): void
        {
            foreach ($this->data() as $value) {
                $group = PermissionGroup::withTrashed()->updateOrCreate(
                    ['name' => $value['name']],
                    ['slug' => $value['slug']]
                );

                if ($group->trashed()) {
                    $group->restore();
                }
            }
        }

        public function data(): array
        {
            return [
                ['name' => 'basic-data', 'slug' => 'basic-data'],
            ];
        }
    }
