<?php

namespace Modules\Basicdata\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BranchesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $branches = [
            [
                'code' => 'ID0010001',
                'name' => 'PT. Bank Artha Graha',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010002',
                'name' => 'SURYOPRANOTO - KC',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010003',
                'name' => 'PURI INDAH - KCP',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010005',
                'name' => 'ARTHA GADING - KC',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010006',
                'name' => 'MANGGA DUA PLAZA',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010008',
                'name' => 'KPO SUDIRMAN',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010009',
                'name' => 'MELAWAI - KC',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010010',
                'name' => 'SUNTER - KC',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010011',
                'name' => 'TANAH ABANG - KCP',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010012',
                'name' => 'BINTARO - KCP',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010015',
                'name' => 'MANGGA BESAR - KCP',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010016',
                'name' => 'BOROBUDUR - KCP',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010017',
                'name' => 'TANGERANG - KCP',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010018',
                'name' => 'BURSA EFEK IND - KCP',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010020',
                'name' => 'P. JAYAKARTA - KC',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010021',
                'name' => 'JATINEGARA - KC',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010022',
                'name' => 'CINERE - KCP',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010023',
                'name' => 'MITRA - KCP',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010025',
                'name' => 'KLP GADING BLVD - KC',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010026',
                'name' => 'MG DUA PSR PAGI - KCP',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010027',
                'name' => 'RAWAMANGUN - KCP',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010028',
                'name' => 'KWITANG',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010029',
                'name' => 'COKROAMINOTO - KCP',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010030',
                'name' => 'ASIA AFRIKA BDG - KC',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010031',
                'name' => 'BKR Bandung - KCP',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010032',
                'name' => 'SETIABUDI BDG - KCP',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010033',
                'name' => 'PAJAJARAN-KCP',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010035',
                'name' => 'BUAH BATU BDG - KCP',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010036',
                'name' => 'RAYA SUDIRMAN BDG -KCP',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010037',
                'name' => 'GARUT - KC',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010038',
                'name' => 'RAJAWALI - KCP',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010039',
                'name' => 'Cimahi - KCP',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010050',
                'name' => 'Ir.Soekarno(MERR)-KCP',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010051',
                'name' => 'PASAR ATUM SBY - KCP',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010052',
                'name' => 'SURABAYA KARET -KC',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010053',
                'name' => 'KEDUNGDORO - KCP',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010055',
                'name' => 'HR MUHAMMAD SBY - KCP',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010056',
                'name' => 'PRAPEN - KCP',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010057',
                'name' => 'SIDOARJO KCP',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010058',
                'name' => 'PASAR TURI - KK',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010060',
                'name' => 'RENON DENPASAR - KC',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010061',
                'name' => 'KUTA BALI - KCP',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010062',
                'name' => 'SUNSET ROAD - KCP',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010063',
                'name' => 'Diponegoro Denpasar KK',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010070',
                'name' => 'PEMUDA MEDAN - KC',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010071',
                'name' => 'CEMARA ASRI MDN - KCP',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010072',
                'name' => 'SUTOMO MEDAN - KCP',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010073',
                'name' => 'JL CIREBON MDN - KCP',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010075',
                'name' => 'ASIA MEDAN - KCP',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010080',
                'name' => 'KARTINI - KC',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010081',
                'name' => 'SURYANEGARA CRB - KCP',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010082',
                'name' => 'PLERED CRB - KCP',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010090',
                'name' => 'MATRAMAN-KC',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010091',
                'name' => 'CEMPAKA PUTIH - KCP',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010092',
                'name' => 'CIKARANG - KCP',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010093',
                'name' => 'ROXY MAS - KC',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010095',
                'name' => 'SAWAH BESAR - KCP',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010096',
                'name' => 'GREENVILLE-KCP',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010097',
                'name' => 'KEBUN JERUK - KCP',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010098',
                'name' => 'KOPI - KCP',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010099',
                'name' => 'PANTAI IND KAPUK - KCP',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010100',
                'name' => 'PLUIT KENCANA - KCP',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010101',
                'name' => 'MANGGA DUA SQUARE-KCP',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010102',
                'name' => 'CIRACAS - KK',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010103',
                'name' => 'DEPOK - KCP',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010105',
                'name' => 'UJUNG MENTENG-KCP',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010106',
                'name' => 'CURUG-KK',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010107',
                'name' => 'BSD - KCP',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010108',
                'name' => 'Tzu Chi - KK',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010109',
                'name' => 'KARAWANG - KCP',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010110',
                'name' => 'PANDANARAN SMG - KC',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010111',
                'name' => 'GANG BESEN - KCP',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010112',
                'name' => 'PEMUDA - KCP',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010120',
                'name' => 'SAMRATULANGI MAN - KC',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010121',
                'name' => 'MANADO MALL - KCP',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010122',
                'name' => 'CALACA MANADO - KCP',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010130',
                'name' => 'MAKASSAR - KC',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010131',
                'name' => 'Veteran Makassar - KCP',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010132',
                'name' => 'RATULANGI - KCP',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010150',
                'name' => 'WATAMPONE - KC',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010160',
                'name' => 'BITUNG - KC',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010170',
                'name' => 'DIPONEGORO AMBON - KC',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010171',
                'name' => 'MARDIKA AMBON - KCP',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010180',
                'name' => 'TERNATE - KC',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010190',
                'name' => 'KENDARI-KC',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010191',
                'name' => 'RAROWATU BOMBANA - KK',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010192',
                'name' => 'ANGATA KONAWE SLT - KK',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010200',
                'name' => 'LAMPUNG-KC',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010201',
                'name' => 'PEMUDA LAMPUNG - KCP',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010210',
                'name' => 'KUPANG - KC',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010220',
                'name' => 'BATAM - KC',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010221',
                'name' => 'BATAM CENTER - KCP',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010230',
                'name' => 'SAMARINDA-KC',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010231',
                'name' => 'BERAU KALTIM - KCP',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010250',
                'name' => 'BOGOR-KC',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010251',
                'name' => 'CIPANAS-KCP',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010260',
                'name' => 'SOLO - KC',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010270',
                'name' => 'GADING SERPONG - KCP',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010272',
                'name' => 'Setiabudi Kuningan KK',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010273',
                'name' => 'TAMAN PALEM - KCP',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010275',
                'name' => 'APART CITY HOME - KK',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010276',
                'name' => 'TEBET - KCP',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010277',
                'name' => 'CIPULIR - KCP',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010278',
                'name' => 'PONDOK INDAH - KK',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010279',
                'name' => 'WILADATIKA - KCP',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010280',
                'name' => 'JABABEKA KK',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010281',
                'name' => 'PEKANBARU - KC',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010282',
                'name' => 'PALEMBANG-KC',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010283',
                'name' => 'RIAU PEKAN BARU - KCP',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010290',
                'name' => 'SAYANGAN PLB - KCP',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010300',
                'name' => 'PONTIANAK - KC',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010310',
                'name' => 'BANJARMASIN - KC',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010320',
                'name' => 'JAMBI - KC',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010330',
                'name' => 'PANGKAL PINANG - KC',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010350',
                'name' => 'BALIKPAPAN - KC',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010380',
                'name' => 'PLAZA II INDAH - KK',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010381',
                'name' => 'CIPUTAT - KK',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010383',
                'name' => 'JEMBATAN LIMA - KK',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => 'ID0010385',
                'name' => 'DAAN MOGOT - KK',
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
        ];

        DB::table('branches')->insert($branches);
    }
}
