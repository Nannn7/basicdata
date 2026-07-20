@extends('layouts.main')

@section('breadcrumbs')
    {{ Breadcrumbs::render(request()->route()->getName()) }}
@endsection

@section('content')
    <div class="w-full grid gap-5 lg:gap-7.5 mx-auto">
        @if (isset($branch->id))
            <form action="{{ route('basicdata.branch.update', $branch->id) }}" method="POST">
                <input type="hidden" name="id" value="{{ $branch->id }}">
                @method('PUT')
            @else
                <form method="POST" action="{{ route('basicdata.branch.store') }}">
        @endif
        @csrf
        <div class="card pb-2.5">
            <div class="card-header" id="basic_settings">
                <h3 class="card-title">
                    {{ isset($branch->id) ? 'Edit' : 'Tambah' }} Branch
                </h3>
                <div class="flex items-center gap-2">
                    <a href="{{ route('basicdata.branch.index') }}" class="btn btn-xs btn-info"><i
                            class="ki-filled ki-exit-left"></i> Back</a>
                </div>
            </div>
            <div class="card-body grid gap-5">
                <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                    <label class="form-label max-w-56">
                        Code
                    </label>
                    <div class="flex flex-wrap items-baseline w-full">
                        <input class="input @error('code') border-danger bg-danger-light @enderror" type="text"
                            name="code" value="{{ $branch->code ?? '' }}" {{ isset($branch->id) ? 'readonly' : '' }}
                            style="{{ isset($branch->id)
                                ? 'background-color:#e5e7eb !important; color:#6b7280 !important; cursor:not-allowed !important; border-color:#d1d5db !important;'
                                : '' }}">
                        @error('code')
                            <em class="alert text-danger text-sm">{{ $message }}</em>
                        @enderror
                    </div>
                </div>
                <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                    <label class="form-label max-w-56">
                        Name
                    </label>
                    <div class="flex flex-wrap items-baseline w-full">
                        <input class="input  @error('name') border-danger bg-danger-light @enderror" type="text"
                            name="name" value="{{ $branch->name ?? '' }}">
                        @error('name')
                            <em class="alert text-danger text-sm">{{ $message }}</em>
                        @enderror
                    </div>
                </div>

                <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                    <label class="form-label max-w-56">
                        Branch Type
                    </label>
                    <div class="flex flex-wrap items-baseline w-full">

                        @php
                            $selectedDalamKota = old(
                                'is_dalam_kota',
                                isset($branch->is_dalam_kota) ? $branch->is_dalam_kota : '',
                            );
                        @endphp

                        <select class="input @error('is_dalam_kota') border-danger bg-danger-light @enderror"
                            name="is_dalam_kota" id="is_dalam_kota">

                            <!-- DEFAULT PILIHAN SAAT CREATE -->
                            <option value="">-- Select Branch Location --</option>

                            <option value="1" {{ $selectedDalamKota == 1 ? 'selected' : '' }}>
                                Dalam Kota
                            </option>

                            <option value="0" {{ $selectedDalamKota == 0 ? 'selected' : '' }}>
                                Luar Kota
                            </option>

                        </select>

                        @error('is_dalam_kota')
                            <em class="alert text-danger text-sm">{{ $message }}</em>
                        @enderror
                    </div>
                </div>
                <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                    <label class="form-label max-w-56">
                        Parent Branch
                    </label>
                    <div class="flex flex-wrap items-baseline w-full">
                        <select class="input @error('parent_id') border-danger bg-danger-light @enderror" name="parent_id">
                            <option value="">-- Select Parent Branch --</option>
                            @foreach ($branches as $parentBranch)
                                @if (!isset($branch->id) || $parentBranch->id != $branch->id)
                                    <option value="{{ $parentBranch->id }}"
                                        {{ isset($branch->parent_id) && $branch->parent_id == $parentBranch->id ? 'selected' : '' }}>
                                        {{ $parentBranch->code }} - {{ $parentBranch->name }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                        @error('parent_id')
                            <em class="alert text-danger text-sm">{{ $message }}</em>
                        @enderror
                    </div>
                </div>
                <div class="flex justify-end">
                    @if (isset($branch->id))
                        @can('basic-data.update')
                            <button type="submit" class="btn btn-primary">
                                Save
                            </button>
                        @endcan
                    @else
                        @can('basic-data.create')
                            <button type="submit" class="btn btn-primary">
                                Save
                            </button>
                        @endcan
                    @endif
                </div>
            </div>
        </div>
        </form>
    </div>
@endsection
