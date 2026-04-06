@extends('layouts.main')

@section('breadcrumbs')
    {{ Breadcrumbs::render(request()->route()->getName()) }}
@endsection

@section('content')
    <div class="w-full grid gap-5 lg:gap-7.5 mx-auto">
        @if (isset($masterNamaDokumen->id))
            <form action="{{ route('basicdata.master-nama-dokumen.update', $masterNamaDokumen->id) }}" method="POST">
                <input type="hidden" name="id" value="{{ $masterNamaDokumen->id }}">
                @method('PUT')
            @else
                <form method="POST" action="{{ route('basicdata.master-nama-dokumen.store') }}">
        @endif
        @csrf
        <div class="card pb-2.5">
            <div class="card-header" id="basic_settings">
                <h3 class="card-title">
                    {{ isset($masterNamaDokumen->id) ? 'Edit' : 'Tambah' }} Master Nama Dokumen
                </h3>
                <div class="flex items-center gap-2">
                    <a href="{{ route('basicdata.master-nama-dokumen.index') }}" class="btn btn-xs btn-info">
                        <i class="ki-filled ki-exit-left"></i> Back
                    </a>
                </div>
            </div>
            <div class="card-body grid gap-5">

                {{-- Kode Produk --}}
                <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                    <label class="form-label max-w-56">Kode Produk</label>
                    <div class="flex flex-wrap items-baseline w-full">
                        <input class="input @error('kode_produk') border-danger bg-danger-light @enderror"
                            type="text" name="kode_produk"
                            value="{{ old('kode_produk', $masterNamaDokumen->kode_produk ?? '') }}">
                        @error('kode_produk')
                            <em class="alert text-danger text-sm">{{ $message }}</em>
                        @enderror
                    </div>
                </div>

                {{-- Jenis Pengikatan --}}
                <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                    <label class="form-label max-w-56">Jenis Pengikatan <span class="text-danger">*</span></label>
                    <div class="flex flex-wrap items-baseline w-full">
                        <select class="select @error('jenis_pengikatan') border-danger bg-danger-light @enderror"
                            name="jenis_pengikatan">
                            <option value="">-- Pilih Jenis Pengikatan --</option>
                            <option value="DOKUMEN PENDUKUNG"
                                {{ old('jenis_pengikatan', $masterNamaDokumen->jenis_pengikatan ?? '') == 'DOKUMEN PENDUKUNG' ? 'selected' : '' }}>
                                Dokumen Pendukung
                            </option>
                            <option value="DOKUMEN LEGAL"
                                {{ old('jenis_pengikatan', $masterNamaDokumen->jenis_pengikatan ?? '') == 'DOKUMEN LEGAL' ? 'selected' : '' }}>
                                Dokumen Legal
                            </option>
                        </select>
                        @error('jenis_pengikatan')
                            <em class="alert text-danger text-sm">{{ $message }}</em>
                        @enderror
                    </div>
                </div>

                {{-- Dokumen Pengikatan --}}
                <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                    <label class="form-label max-w-56">Dokumen Pengikatan <span class="text-danger">*</span></label>
                    <div class="flex flex-wrap items-baseline w-full">
                        <input class="input @error('dokumen_pengikatan') border-danger bg-danger-light @enderror"
                            type="text" name="dokumen_pengikatan"
                            value="{{ old('dokumen_pengikatan', $masterNamaDokumen->dokumen_pengikatan ?? '') }}">
                        @error('dokumen_pengikatan')
                            <em class="alert text-danger text-sm">{{ $message }}</em>
                        @enderror
                    </div>
                </div>

                {{-- Agunan --}}
                {{--  <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                    <label class="form-label max-w-56">Agunan</label>
                    <div class="flex flex-wrap items-baseline w-full">
                        <input class="input @error('agunan') border-danger bg-danger-light @enderror"
                            type="text" name="agunan" maxlength="5"
                            value="{{ old('agunan', $masterNamaDokumen->agunan ?? '') }}">
                        @error('agunan')
                            <em class="alert text-danger text-sm">{{ $message }}</em>
                        @enderror
                    </div>
                </div>  --}}

                {{-- Checkbox Fields --}}
                {{--  <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                    <label class="form-label max-w-56">Kolom yang Ditampilkan</label>
                    <div class="w-full">
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">

                            @php
                                $checkboxFields = [
                                    'nomor'           => 'Nomor',
                                    'tgl_mulai'       => 'Tgl Mulai',
                                    'tgl_jtempo'      => 'Tgl Jatuh Tempo',
                                    'atas_nama'       => 'Atas Nama',
                                    'peringkat'       => 'Peringkat',
                                    'nominal'         => 'Nominal',
                                    'keterangan'      => 'Keterangan',
                                    'atas_dep'        => 'Atas Dep',
                                    'notaris'         => 'Notaris',
                                    'atas_sertifikat' => 'Atas Sertifikat',
                                    'objek'           => 'Objek',
                                    'bukti_hak'       => 'Bukti Hak',
                                    'nomor_spk'       => 'Nomor SPK',
                                    'tgl_spk'         => 'Tgl SPK',
                                    'nama_lo'         => 'Nama LO',
                                    'nama_ao'         => 'Nama AO',
                                    'jenis_pinjaman'  => 'Jenis Pinjaman',
                                    'no_fasilitas'    => 'No Fasilitas',
                                    'alamat'          => 'Alamat',
                                    'developer'       => 'Developer',
                                    'tgljtcover'      => 'Tgl JT Cover',
                                    'tglawcover'      => 'Tgl AW Cover',
                                    'nocovernote'     => 'No Cover Note',
                                    'tgldoc_lengkap'  => 'Tgl Doc Lengkap',
                                    'tgldoc_terima'   => 'Tgl Doc Terima',
                                ];
                            @endphp

                            @foreach ($checkboxFields as $field => $label)
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input class="checkbox checkbox-sm" type="checkbox" name="{{ $field }}" value="1"
                                        {{ old($field, $masterNamaDokumen->$field ?? 0) ? 'checked' : '' }}>
                                    <span class="text-sm text-gray-700">{{ $label }}</span>
                                </label>
                            @endforeach

                        </div>
                    </div>
                </div>  --}}

                <div class="flex justify-end">
                    @if (isset($masterNamaDokumen->id))
                        @can('basic-data.update')
                            <button type="submit" class="btn btn-primary">Save</button>
                        @endcan
                    @else
                        @can('basic-data.create')
                            <button type="submit" class="btn btn-primary">Save</button>
                        @endcan
                    @endif
                </div>
            </div>
        </div>
        </form>
    </div>
@endsection
