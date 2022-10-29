@extends('layouts.app')

@section('style')
    @livewireStyles
    <style>
        .readonly {
            cursor: not-allowed;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-md-12">
                <livewire:penjualan.detail.add-form :penjualan_id="$penjualan_id" />
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md-8 col-12 mb-2">
                <livewire:penjualan.detail.list-detail :penjualan_id="$penjualan_id" />
            </div>
            <div class="col-md-4 col-12 mb-2">
                <livewire:penjualan.detail.submit-form :penjualan_id="$penjualan_id" />
            </div>
        </div>
    </div>
@endsection

@section('script')
    @livewireScripts
@endsection
