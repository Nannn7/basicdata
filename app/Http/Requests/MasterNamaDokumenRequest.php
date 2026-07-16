<?php

    namespace Modules\Basicdata\Http\Requests;

    use Illuminate\Foundation\Http\FormRequest;

    class MasterNamaDokumenRequest extends FormRequest
    {
        public function authorize(): bool
        {
            return true;
        }

        public function rules(): array
        {
            return [
                'kode_produk'        => 'nullable|string|max:255',
                'jenis_pengikatan'   => 'required|string|in:DOKUMEN PENDUKUNG,DOKUMEN LEGAL',
                'dokumen_pengikatan' => 'required|string|max:255',
                'nomor'              => 'boolean',
                'tgl_mulai'          => 'boolean',
                'tgl_jtempo'         => 'boolean',
                'atas_nama'          => 'boolean',
                'peringkat'          => 'boolean',
                'nominal'            => 'boolean',
                'keterangan'         => 'boolean',
                'atas_dep'           => 'boolean',
                'notaris'            => 'boolean',
                'atas_sertifikat'    => 'boolean',
                'objek'              => 'boolean',
                'bukti_hak'          => 'boolean',
                'nomor_spk'          => 'boolean',
                'tgl_spk'            => 'boolean',
                'nama_lo'            => 'boolean',
                'nama_ao'            => 'boolean',
                'jenis_pinjaman'     => 'boolean',
                'no_fasilitas'       => 'boolean',
                'alamat'             => 'boolean',
                'developer'          => 'boolean',
                'tgljtcover'         => 'boolean',
                'tglawcover'         => 'boolean',
                'nocovernote'        => 'boolean',
                'agunan'             => 'nullable|string|max:5',
                'tgldoc_lengkap'     => 'boolean',
                'tgldoc_terima'      => 'boolean',
            ];
        }

        public function messages(): array
        {
            return [
                'jenis_pengikatan.required' => 'Jenis Pengikatan wajib dipilih.',
                'jenis_pengikatan.in'       => 'Jenis Pengikatan harus Dokumen Pendukung atau Dokumen Legal.',
                'dokumen_pengikatan.required' => 'Dokumen Pengikatan wajib diisi.',
            ];
        }

        protected function prepareForValidation()
        {
            // Checkbox yang tidak dicentang tidak terkirim, default ke 0
            $checkboxFields = [
                'nomor', 'tgl_mulai', 'tgl_jtempo', 'atas_nama', 'peringkat',
                'nominal', 'keterangan', 'atas_dep', 'notaris', 'atas_sertifikat',
                'objek', 'bukti_hak', 'nomor_spk', 'tgl_spk', 'nama_lo', 'nama_ao',
                'jenis_pinjaman', 'no_fasilitas', 'alamat', 'developer',
                'tgljtcover', 'tglawcover', 'nocovernote', 'tgldoc_lengkap', 'tgldoc_terima',
            ];

            $mergeData = [];
            foreach ($checkboxFields as $field) {
                $mergeData[$field] = $this->has($field) ? 1 : 0;
            }

            $this->merge($mergeData);
        }
    }
