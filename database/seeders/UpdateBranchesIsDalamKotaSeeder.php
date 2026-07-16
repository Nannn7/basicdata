<?php

namespace Modules\Basicdata\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Basicdata\Models\Branch;

class UpdateBranchesIsDalamKotaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $codes = [
            '0001','0005','0012','0250','0016','0018','0279','0092','0022','0251',
            '0029','0270','0096','0109','0098','2005','0008','0028','0015',
            '0006','0090','0009','0023','0020','0099','0003','0010','0002',
            '0273','0011','0105',
        ];

        Branch::query()->update(['is_dalam_kota' => false]);

        foreach ($codes as $code) {
            Branch::where('code', 'like', '%' . $code)
                ->update(['is_dalam_kota' => true]);
        }

        $newBranches = [
            [
                'code' => 'ID0012005',
                'name' => 'KORPORASI',
                'is_dalam_kota' => true,
            ],
            [
                'code' => 'ID0010172',
                'name' => 'AMBON TUAL MALUKU',
                'is_dalam_kota' => false,
            ],
        ];

        foreach ($newBranches as $branch) {
            Branch::updateOrCreate(
                ['code' => $branch['code']],
                [
                    'name' => $branch['name'],
                    'is_dalam_kota' => $branch['is_dalam_kota'],
                    'status' => true,
                ]
            );
        }
    }
}
