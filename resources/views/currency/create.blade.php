@extends('layouts.main')

@section('breadcrumbs')
    {{ Breadcrumbs::render(request()->route()->getName()) }}
@endsection

@section('content')
    <div class="w-full grid gap-5 lg:gap-7.5 mx-auto">
        @if(isset($currency->id))
            <form action="{{ route('basicdata.currency.update', $currency->id) }}" method="POST">
                <input type="hidden" name="id" value="{{ $currency->id }}">
                @method('PUT')
                @else
                    <form method="POST" action="{{ route('basicdata.currency.store') }}">
                        @endif
                        @csrf
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
                                        <input class="input  @error('code') border-danger bg-danger-light @enderror" type="text" name="code" value="{{ $currency->code ?? '' }}">
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
                                    <button type="submit" class="btn btn-primary">
                                        Save
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
    </div>
@endsection
