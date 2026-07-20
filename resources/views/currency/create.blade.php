@extends('layouts.main')

@section('breadcrumbs')
    {{ Breadcrumbs::render(request()->route()->getName()) }}
@endsection

@section('content')
    <div class="w-full grid gap-5 lg:gap-7.5 mx-auto">
        <form method="POST" action="{{ isset($currency->id) ? route('basicdata.currency.update', $currency->id) : route('basicdata.currency.store') }}">
            @csrf
            @if(isset($currency->id))
                <input type="hidden" name="id" value="{{ $currency->id }}">
                @method('PUT')
            @endif
            <div class="card pb-2.5">
                <div class="card-header" id="basic_settings">
                    <h3 class="card-title">
                        {{ isset($currency->id) ? 'Edit' : 'Tambah' }} Currency
                    </h3>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('basicdata.currency.index') }}" class="btn btn-xs btn-info"><i class="ki-filled ki-exit-left"></i> Back</a>
                    </div>
                </div>
                <div class="card-body grid gap-5">
                    <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                        <label class="form-label max-w-56">
                            Code
                        </label>
                        <div class="flex flex-wrap items-baseline w-full">
                            <input class="input  @error('code') border-danger bg-danger-light @enderror" type="text" name="code" value="{{ $currency->code ?? '' }}" {{ isset($currency->id) ? 'readonly' : '' }}
                            style="{{ isset($currency->id)
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
                            <input class="input  @error('name') border-danger bg-danger-light @enderror" type="text" name="name" value="{{ $currency->name ?? '' }}">
                            @error('name')
                            <em class="alert text-danger text-sm">{{ $message }}</em>
                            @enderror
                        </div>
                    </div>
                    <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                        <label class="form-label max-w-56">
                            Symbol
                        </label>
                        <div class="flex flex-wrap items-baseline w-full">
                            <input class="input @error('symbol') border-danger bg-danger-light @enderror" type="text" name="symbol" value="{{ $currency->symbol ?? '' }}">
                            @error('symbol')
                            <em class="alert text-danger text-sm">{{ $message }}</em>
                            @enderror
                        </div>
                    </div>
                    <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                        <label class="form-label max-w-56">
                            Decimal Places
                        </label>
                        <div class="flex flex-wrap items-baseline w-full">
                            <input class="input  @error('decimal_places') border-danger bg-danger-light @enderror" type="number" min="0" max="3" name="decimal_places" value="{{ $currency->decimal_places ?? '' }}">
                            @error('decimal_places')
                            <em class="alert text-danger text-sm">{{ $message }}</em>
                            @enderror
                        </div>
                    </div>
                    <div class="flex justify-end">
                        @if(isset($currency->id))
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
