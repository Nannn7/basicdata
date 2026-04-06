<?php

    namespace Modules\Basicdata\Models;

    use Illuminate\Database\Eloquent\Model;

    class MasterNamaDokumen extends Model
    {
        protected $table = 'tbl_master_nama_dokumen';

        protected $fillable = [
            'kode_produk',
            'jenis_pengikatan',
            'dokumen_pengikatan',
            'nomor',
            'tgl_mulai',
            'tgl_jtempo',
            'atas_nama',
            'peringkat',
            'nominal',
            'keterangan',
            'atas_dep',
            'notaris',
            'atas_sertifikat',
            'objek',
            'bukti_hak',
            'nomor_spk',
            'tgl_spk',
            'nama_lo',
            'nama_ao',
            'jenis_pinjaman',
            'no_fasilitas',
            'alamat',
            'developer',
            'tgljtcover',
            'tglawcover',
            'nocovernote',
            'agunan',
            'tgldoc_lengkap',
            'tgldoc_terima',
        ];

        protected $casts = [
            'nomor'           => 'boolean',
            'tgl_mulai'       => 'boolean',
            'tgl_jtempo'      => 'boolean',
            'atas_nama'       => 'boolean',
            'peringkat'       => 'boolean',
            'nominal'         => 'boolean',
            'keterangan'      => 'boolean',
            'atas_dep'        => 'boolean',
            'notaris'         => 'boolean',
            'atas_sertifikat' => 'boolean',
            'objek'           => 'boolean',
            'bukti_hak'       => 'boolean',
            'nomor_spk'       => 'boolean',
            'tgl_spk'         => 'boolean',
            'nama_lo'         => 'boolean',
            'nama_ao'         => 'boolean',
            'jenis_pinjaman'  => 'boolean',
            'no_fasilitas'    => 'boolean',
            'alamat'          => 'boolean',
            'developer'       => 'boolean',
            'tgljtcover'      => 'boolean',
            'tglawcover'      => 'boolean',
            'nocovernote'     => 'boolean',
            'tgldoc_lengkap'  => 'boolean',
            'tgldoc_terima'   => 'boolean',
        ];
    }
