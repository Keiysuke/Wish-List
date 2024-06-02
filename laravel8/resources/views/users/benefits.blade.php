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
        document.getElementById('content-filters').classList.toggle('hidden');
    }

    function change_page(nb){
        document.getElementById('page').value = nb;
        get_benefits();
    }

    function get_benefits(){
        let websites = Array();
        let tags = Array();
        Array.from(document.getElementsByClassName('filter-website')).forEach(el => {
            if(el.checked) websites.push(el.name);
        });
        Array.from(document.getElementsByClassName('filter-tag')).forEach(el => {
            if(el.checked) tags.push(el.name);
        });
        
        myFetch('{{ route('postUserBenefits') }}', {method: 'post', csrf: true}, {
            user_id: parseInt(document.getElementById('user-id').value),
            date_from: document.getElementById('date-from').value,
            date_to: document.getElementById('date-to').value,
            nb_results: document.querySelector('input[name="f_nb_results"]:checked').value,
            page: document.getElementById('page').value,
            websites: websites,
            no_tag: document.getElementById('no-tag').checked,
            exclusive_tags: document.getElementById('exclusive-tags').checked,
            tags: tags,
            purchased: document.querySelector('input[name="purchased"]:checked').value,
        }).then(response => {
            if (response.ok) return response.json();
        }).then(results => {
            document.getElementById('content-results').innerHTML = results.html; //lists/historic/purchases
            document.getElementById('btn-go-up').click();
        });
    }

    document.forms['filter-benefits'].onsubmit = (e) => {
        e.preventDefault();
        document.getElementById('page').value = 1;
        get_benefits();
    }

    document.getElementById('check-all-websites').addEventListener('change', (event) => {
        Array.from(document.getElementsByClassName('filter-website')).forEach(el => {
            el.checked = !event.target.checked;
        });
    });

    document.getElementById('check-all-tags').addEventListener('change', (event) => {
        Array.from(document.getElementsByClassName('filter-tag')).forEach(el => {
            el.checked = !event.target.checked;
        });
    });

    document.getElementById('reset-benefits-filters').addEventListener('click', reset_filters);
    
    function reset_filters(){
        document.getElementById('date-from').value = '';
        document.getElementById('date-to').value = '';
        document.getElementById('page').value = 1;
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

    <form id="filter-benefits">
        @include("partials.filters.benefits")
    </form>

    <input id="user-id" type="hidden" value="{{ auth()->user()->id }}"/>
    <div id="content-results"></div>
    <input type="hidden" id="page" name="cur_page" value="{{ isset($paginator)? $paginator->cur_page : 1 }}">
@endsection