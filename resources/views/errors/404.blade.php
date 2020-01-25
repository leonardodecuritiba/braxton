@extends('layouts.app')

@section('title', '')

{{--@section('route', route('cliente'))--}}

@section('style_content')

    <!-- Jquery DataTable Plugin Css -->
    @include('layouts.inc.datatable.css')

    <!-- Sweetalert Css -->
    @include('layouts.inc.sweetalert.css')

@endsection

@section('page_content')
    <div class="four-zero-four">
        <div class="four-zero-four-container">
            <div class="error-code">404</div>
            <div class="error-message">Página Inexistente</div>
            <div class="button-place">
                <a href="{{route('index')}}" class="btn btn-default btn-lg waves-effect">Home</a>
            </div>
        </div>
    </div>
@endsection


@section('script_content')


    <!-- Jquery DataTable Plugin Js -->
    @include('layouts.inc.datatable.js')

    <!-- SweetAlert Plugin Js -->
    @include('layouts.inc.sweetalert.js')

@endsection