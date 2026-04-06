<?php

    namespace Modules\Basicdata\Exports;

    use Modules\Basicdata\Models\MasterNamaDokumen;
    use Maatwebsite\Excel\Concerns\FromCollection;
    use Maatwebsite\Excel\Concerns\WithHeadings;
    use Maatwebsite\Excel\Concerns\WithMapping;

    class MasterNamaDokumenExport implements FromCollection, WithHeadings, WithMapping
    {
        protected $search;
        protected $jenisPengikatan;

        public function __construct($search = null, $jenisPengikatan = null)
        {
            $this->search          = $search;
            $this->jenisPengikatan = $jenisPengikatan;
        }

        public function collection()
        {
            $query = MasterNamaDokumen::query();

            if ($this->search) {
                $search = strtolower($this->search);
                $query->where(function ($q) use ($search) {
                    $q->whereRaw('LOWER(kode_produk) LIKE ?', ['%' . $search . '%']);
                    $q->orWhereRaw('LOWER(jenis_pengikatan) LIKE ?', ['%' . $search . '%']);
                    $q->orWhereRaw('LOWER(dokumen_pengikatan) LIKE ?', ['%' . $search . '%']);
                });
            }

            if ($this->jenisPengikatan) {
                $query->where('jenis_pengikatan', $this->jenisPengikatan);
            }

            return $query->get();
        }

        public function headings(): array
        {
            return [
                'ID', 'Kode Produk', 'Jenis Pengikatan', 'Dokumen Pengikatan',
                'Nomor', 'Tgl Mulai', 'Tgl Jatuh Tempo', 'Atas Nama', 'Peringkat',
                'Nominal', 'Keterangan', 'Atas Dep', 'Notaris', 'Atas Sertifikat',
                'Objek', 'Bukti Hak', 'Nomor SPK', 'Tgl SPK', 'Nama LO', 'Nama AO',
                'Jenis Pinjaman', 'No Fasilitas', 'Alamat', 'Developer',
                'Tgl JT Cover', 'Tgl AW Cover', 'No Cover Note', 'Agunan',
                'Tgl Doc Lengkap', 'Tgl Doc Terima', 'Created At', 'Updated At',
            ];
        }

        public function map($item): array
        {
            return [
                $item->id,
                $item->kode_produk,
                $item->jenis_pengikatan,
                $item->dokumen_pengikatan,
                $item->nomor ? 'Ya' : 'Tidak',
                $item->tgl_mulai ? 'Ya' : 'Tidak',
                $item->tgl_jtempo ? 'Ya' : 'Tidak',
                $item->atas_nama ? 'Ya' : 'Tidak',
                $item->peringkat ? 'Ya' : 'Tidak',
                $item->nominal ? 'Ya' : 'Tidak',
                $item->keterangan ? 'Ya' : 'Tidak',
                $item->atas_dep ? 'Ya' : 'Tidak',
                $item->notaris ? 'Ya' : 'Tidak',
                $item->atas_sertifikat ? 'Ya' : 'Tidak',
                $item->objek ? 'Ya' : 'Tidak',
                $item->bukti_hak ? 'Ya' : 'Tidak',
                $item->nomor_spk ? 'Ya' : 'Tidak',
                $item->tgl_spk ? 'Ya' : 'Tidak',
                $item->nama_lo ? 'Ya' : 'Tidak',
                $item->nama_ao ? 'Ya' : 'Tidak',
                $item->jenis_pinjaman ? 'Ya' : 'Tidak',
                $item->no_fasilitas ? 'Ya' : 'Tidak',
                $item->alamat ? 'Ya' : 'Tidak',
                $item->developer ? 'Ya' : 'Tidak',
                $item->tgljtcover ? 'Ya' : 'Tidak',
                $item->tglawcover ? 'Ya' : 'Tidak',
                $item->nocovernote ? 'Ya' : 'Tidak',
                $item->agunan,
                $item->tgldoc_lengkap ? 'Ya' : 'Tidak',
                $item->tgldoc_terima ? 'Ya' : 'Tidak',
                $item->created_at,
                $item->updated_at,
            ];
        }
    }
