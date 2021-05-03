@extends('layouts.layout-2')
@section('styles')
    <link rel="stylesheet" href="{{ mix('/vendor/libs/datatables/datatables.css') }}">
    <link rel="stylesheet" href="{{ mix('/vendor/libs/select2/select2.css') }}">
    <link rel="stylesheet" href="{{ mix('/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css') }}">
@endsection

@section('scripts')
    <!-- Dependencies -->
    <script src="{{ mix('/vendor/libs/datatables/datatables.js') }}"></script>
    <script src="{{ mix('/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ mix('/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
@endsection

@section('content')
    <h4 class="font-weight-bold py-3 mb-4">{{ $title }}</h4>

    <div class="card">

        @livewire('thotam-buddy::buddy-canhan-livewire')

        <div class="px-4 mb-4">
            <livewire:datatable model="Thotam\ThotamHr\Models\HR" exportable searchable="key" hideable="select"/>
        </div>
    </div>

@endsection
