@extends('template')

@section('metas')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('breadcrumbs')
    {{ Breadcrumbs::render('list', 'product') }}
@endsection

@section('css')
    <link href="{{ asset('css/pagination.css') }}" rel="stylesheet">
    <link href="{{ asset('css/products_search.css') }}" rel="stylesheet">
@endsection

@section('js')
<script type="text/javascript" src="{{ URL::asset('js/my_fetch.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/productsSearch.js') }}"></script>
@endsection

@section('content')
    <form id="search-products">
        <div class="sticky-search-bar off" id="result-bar">
            <h4 class="font-medium" id="nb-results"></h4>
            @include('partials.products.search_bar', ['sortBy' => $sortBy])
        </div>
        <hr class="mt-2"/>
        @include('partials.filters.products')
    </form>
    <div id="content-results">
    </div>
    <input type="hidden" id="page" name="cur_page" value="{{ $paginator->cur_page }}">
    <input type="hidden" id="url" name="url" value="{{ Request::path() }}">
@endsection