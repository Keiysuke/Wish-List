@extends('template')

@section('metas')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('breadcrumbs')
    {{ Breadcrumbs::render('historic', $kind) }}
@endsection

@section('css')
    <link href="{{ asset('css/list_products.css') }}" rel="stylesheet">
    <link href="{{ asset('css/pagination.css') }}" rel="stylesheet">
@endsection

@section('js')
<script type="text/javascript" src="{{ URL::asset('js/my_fetch.js') }}"></script>
<script>
    function toggle_filters(){
        document.getElementById('content-filters').classList.toggle('hidden');
    }

    function change_page(nb){
        document.getElementById('page').value = nb;
        get_historic();
    }

    function get_historic(){
        myFetch('{{ route('postUserHistoric') }}', {method: 'post', csrf: true}, {
            user_id: parseInt(document.getElementById('user-id').value),
            kind: "{{ $kind }}",
            date_from: document.getElementById('date-from').value,
            date_to: document.getElementById('date-to').value,
            page: document.getElementById('page').value,
        }).then(response => {
            if (response.ok) return response.json();
        }).then(results => {
            document.getElementById('content-results').innerHTML = results.html; //lists/historic/purchases
            document.getElementById('btn-go-up').click();
        });
    }

    document.forms['filter-historic'].onsubmit = (e) => {
        e.preventDefault();
        document.getElementById('page').value = 1;
        get_historic();
    }
    
    get_historic();
</script>
@endsection

@section('content')
    <div class="w-full flex inline-flex justify-center gap-2">
        @if($purchases) <span class="font-semibold text-orange-500">Mes achats</span> / <a href="{{ route('userHistoric', 'sellings') }}" class="link">Mes ventes</a>
        @else <a href="{{ route('userHistoric', 'purchases') }}" class="link">Mes achats</a> / <span class="font-semibold text-green-500">Mes ventes</span>
        @endif
    </div>
    <div class="flex align-start gap-1">
        @if($purchases) <x-svg.big.cart class="icon-sm"/>
        @else <x-svg.big.truck class="icon-sm"/>
        @endif
        
        <div class="w-full relative flex">
            <h2>Mon historique {{ $purchases? "d'achats" : "de ventes" }}</h2>
            <div class="absolute right-0 bottom-0" onClick="toggle_filters();">
                <span class="title-icon cursor-pointer inline-flex">
                    <x-svg.filter class="icon-xs"/>
                </span>
            </div>
        </div>
    </div>
    <hr/>

    <form id="filter-historic">
        @include("partials.filters.group_buy")
    </form>

    <input id="user-id" type="hidden" value="{{ auth()->user()->id }}"/>
    <div id="content-results"></div>
    <input type="hidden" id="page" name="cur_page" value="{{ isset($paginator)? $paginator->cur_page : 1 }}">
@endsection