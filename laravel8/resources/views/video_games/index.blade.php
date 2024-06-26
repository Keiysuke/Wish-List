@extends('template')

@section('metas')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('breadcrumbs')
    {{ Breadcrumbs::render('list', 'video_game') }}
@endsection

@section('css')
    <link href="{{ asset('css/pagination.css') }}" rel="stylesheet">
    <link href="{{ asset('css/video_games_search.css') }}" rel="stylesheet">
@endsection

@section('js')
<script type="text/javascript" src="{{ URL::asset('js/my_fetch.js') }}"></script>
<script>
    searchVideoGames();

    function toggle_filters(){
        document.getElementById('icon-filter').classList.toggle('on');
        if(window.scrollY >= '40'){
            window.scrollTo(0, 0);
            if(document.getElementById('content-filters').classList.contains('hidden')) document.getElementById('content-filters').classList.remove('hidden');
        }else
            document.getElementById('content-filters').classList.toggle('hidden');
    }
    function sort(order_by){
        document.getElementById('icon-asc-sort').classList.toggle('hidden');
        document.getElementById('icon-desc-sort').classList.toggle('hidden');
        document.getElementById('order-by').value = order_by;
        document.getElementById('title-order-by').title = (order_by === 'asc')? 'Ordre croissant' : 'Ordre décroissant';
        searchVideoGames();
    }
    function display_result(kind){
        document.getElementById('result-icon-list').classList.toggle('hidden');
        document.getElementById('result-icon-grid').classList.toggle('hidden');
        document.getElementById('list').value = (kind === 'list')? 'list' : 'grid';
        document.getElementById('icon-list').title = (kind === 'list')? 'Liste' : 'Grille';
        searchVideoGames();
    }
    function change_page(nb){
        document.getElementById('page').value = nb;
        searchVideoGames();
    }

    function searchVideoGames(){
        let vg_supports = Array();
        Array.from(document.getElementsByClassName('filter-vg-support')).forEach(el => {
            if(el.checked) vg_supports.push(el.name);
        });
        myFetch('{{ route('videoGamesSearch') }}', {method: 'post', csrf: true}, {
            search_text: document.getElementById('search-text').value,
            sort_by: document.getElementById('sort-by').value,
            order_by: document.getElementById('order-by').value,
            list: document.getElementById('list').value,
            page: document.getElementById('page').value,
            vg_supports: vg_supports,
            purchased: document.querySelector('input[name="purchased"]:checked').value,
            f_nb_results: document.querySelector('input[name="f_nb_results"]:checked').value,
        }).then(response => {
            if (response.ok) {
                document.getElementById('search-text').classList.remove('border');
                return response.json();
            } else {
                if(response.status == 422) {
                    document.getElementById('search-text').classList.add('border');
                    document.getElementById('search-text').classList.add('border-red-500');
                }
                return null;
            }
        }).then(video_games => {
            document.getElementById('content-results').innerHTML = video_games.html;
            if(video_games === null) return;
            document.getElementById('nb-results').innerHTML = video_games.nb_results+' Résultat(s)';
        });
    }
    
    document.getElementById('check-all-vg-supports').addEventListener('change', (event) => {
        Array.from(document.getElementsByClassName('filter-vg-support')).forEach(el => {
            el.checked = !event.target.checked;
        });
    });

    document.forms['search-video-games'].onsubmit = (e) => {
        e.preventDefault();
        document.getElementById('page').value = 1;
        searchVideoGames();
    }

    window.addEventListener('scroll', () => {
        if(window.scrollY >= '40') document.getElementById('result-bar').setAttribute('class', 'sticky-search-bar on');
        else document.getElementById('result-bar').setAttribute('class', 'sticky-search-bar off');
    });
</script>
@endsection

@section('content')
    <form id="search-video-games">
        <div class="sticky-search-bar off" id="result-bar">
            <h4 class="font-medium" id="nb-results"></h4>
            @include('partials.video_games.search_bar', ['sortBy' => $sortBy])
        </div>
        
        <hr class="mt-2"/>
        @include('partials.filters.video_games')
    </form>
    
    <div id="content-results">
    </div>
    <input type="hidden" id="page" name="cur_page" value="{{ $paginator->cur_page }}">
    <input type="hidden" id="url" name="url" value="{{ Request::path() }}">
@endsection