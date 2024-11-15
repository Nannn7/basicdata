@extends('layouts.main')

@section('breadcrumbs')
    {{ Breadcrumbs::render(request()->route()->getName()) }}
@endsection

@section('content')
    <div class="w-full grid gap-5 lg:gap-7.5 mx-auto">
        @if(isset($holiday->id))
            <form action="{{ route('basicdata.holidaycalendar.update', $holiday->id) }}" method="POST">
                <input type="hidden" name="id" value="{{ $holiday->id }}">
                @method('PUT')
                @else
                    <form method="POST" action="{{ route('basicdata.holidaycalendar.store') }}">
                        @endif
                        @csrf
                        <div class="card pb-2.5">
                            <div class="card-header" id="basic_settings">
                                <h3 class="card-title">
                                    {{ isset($holiday->id) ? 'Edit' : 'Tambah' }} Hari Libur
                                </h3>
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('basicdata.holidaycalendar.index') }}" class="btn btn-xs btn-info"><i class="ki-filled ki-exit-left"></i> Back</a>
                                </div>
                            </div>
                            <div class="card-body grid gap-5">
                                <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                                    <label class="form-label max-w-56">
                                        Tanggal
                                    </label>
                                    <div class="flex flex-wrap items-baseline w-full">
                                        <input class="input @error('date') border-danger bg-danger-light @enderror" type="date" name="date" value="{{ old('date', isset($holiday) ? $holiday->date->format('Y-m-d') : '') }}">
                                        @error('date')
                                        <em class="alert text-danger text-sm">{{ $message }}</em>
                                        @enderror
                                    </div>
                                </div>
                                <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                                    <label class="form-label max-w-56">
                                        Deskripsi
                                    </label>
                                    <div class="flex flex-wrap items-baseline w-full">
                                        <input class="input @error('description') border-danger bg-danger-light @enderror"
                                               type="text"
                                               name="description"
                                               value="{{ old('description', $holiday->description ?? '') }}">
                                        @error('description')
                                        <em class="alert text-danger text-sm">{{ $message }}</em>
                                        @enderror
                                    </div>
                                </div>
                                <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                                    <label class="form-label max-w-56">
                                        Tipe
                                    </label>
                                    <div class="flex flex-wrap items-baseline w-full">
                                        <select class="select @error('type') border-danger bg-danger-light @enderror" name="type">
                                            <option value="">Pilih Tipe</option>
                                            <option value="national_holiday" {{ old('type', $holiday->type ?? '') == 'national_holiday' ? 'selected' : '' }}>Nasional</option>
                                            <option value="collective_leave" {{ old('type', $holiday->type ?? '') == 'collective_leave' ? 'selected' : '' }}>Cuti Bersama</option>
                                        </select>
                                        @error('type')
                                        <em class="alert text-danger text-sm">{{ $message }}</em>
                                        @enderror
                                    </div>
                                </div>
                                <div class="flex justify-end">
                                    <button type="submit" class="btn btn-primary">
                                        Save
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
    </div>
@endsection
