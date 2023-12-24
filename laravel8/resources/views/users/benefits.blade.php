@extends('template')

@section('metas')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('breadcrumbs')
    {{ Breadcrumbs::render('benefits') }}
@endsection

@section('css')
    <link href="{{ asset('css/list_products.css') }}" rel="stylesheet">
    <link href="{{ asset('css/pagination.css') }}" rel="stylesheet">
@endsection

@section('js')
<script type="text/javascript" src="{{ URL::asset('js/my_fetch.js') }}"></script>
<script>
    function toggle_filters(){
        document.querySelector('#content_filters').classList.toggle('hidden');
    }

    function change_page(nb){
        document.getElementById('page').value = nb;
        get_benefits();
    }

    function get_benefits(){
        my_fetch('{{ route('post_user_benefits') }}', {method: 'post', csrf: true}, {
            user_id: document.querySelector('#user_id').value,
            date_from: document.querySelector('#date_from').value,
            date_to: document.querySelector('#date_to').value,
            page: document.getElementById('page').value,
        }).then(response => {
            if (response.ok) return response.json();
        }).then(results => {
            document.getElementById('content_results').innerHTML = results.html; //lists/historic/purchases
            document.querySelector('#btn-go-up').click();
        });
    }

    document.forms['filter_benefits'].onsubmit = (e) => {
        e.preventDefault();
        document.getElementById('page').value = 1;
        get_benefits();
    }

    document.querySelector('#reset_benefits_filters').addEventListener('click', reset_filters);
    
    function reset_filters(){
        document.querySelector('#date_from').value = '';
        document.querySelector('#date_to').value = '';
        document.querySelector('#page').value = 1;
        get_benefits();
    }
    
    get_benefits();
</script>
@endsection

@section('content')
    <div class="flex align-start gap-1">
        <x-svg.big.euro class="icon-sm"/>
        
        <div class="w-full relative flex">
            <h2>Mes bénéfices</h2>
            <div class="absolute right-0 bottom-0" onClick="toggle_filters();">
                <span class="title-icon cursor-pointer inline-flex">
                    <x-svg.filter class="icon-xs"/>
                </span>
            </div>
        </div>
    </div>
    <hr/>

    <form id="filter_benefits">
        @include("partials.products.benefits_filter")
    </form>

    <input id="user_id" type="hidden" value="{{ auth()->user()->id }}"/>
    <div id="content_results"></div>
    <input type="hidden" id="page" name="cur_page" value="{{ isset($paginator)? $paginator->cur_page : 1 }}">
@endsection