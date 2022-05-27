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
    search_video_games();

    function toggle_filters(){
        document.querySelector('#icon_filter').classList.toggle('on');
        if(window.scrollY >= '40'){
            window.scrollTo(0, 0);
            if(document.getElementById('content_filters').classList.contains('hidden')) document.getElementById('content_filters').classList.remove('hidden');
        }else
            document.getElementById('content_filters').classList.toggle('hidden');
    }
    function sort(order_by){
        document.getElementById('icon_asc_sort').classList.toggle('hidden');
        document.getElementById('icon_desc_sort').classList.toggle('hidden');
        document.getElementById('order_by').value = order_by;
        document.getElementById('title_order_by').title = (order_by === 'asc')? 'Ordre croissant' : 'Ordre décroissant';
        search_video_games();
    }
    function display_result(kind){
        document.getElementById('result_icon_list').classList.toggle('hidden');
        document.getElementById('result_icon_grid').classList.toggle('hidden');
        document.getElementById('list').value = (kind === 'list')? 'list' : 'grid';
        document.getElementById('icon_list').title = (kind === 'list')? 'Liste' : 'Grille';
        search_video_games();
    }
    function change_page(nb){
        document.getElementById('page').value = nb;
        search_video_games();
    }

    function search_video_games(){
        let vg_supports = Array();
        Array.from(document.getElementsByClassName('filter_vg_support')).forEach(el => {
            if(el.checked) vg_supports.push(el.name);
        });
        my_fetch('{{ route('video_games_search') }}', {method: 'post', csrf: true}, {
            search_text: document.getElementById('search_text').value,
            sort_by: document.getElementById('sort_by').value,
            order_by: document.getElementById('order_by').value,
            list: document.getElementById('list').value,
            page: document.getElementById('page').value,
            vg_supports: vg_supports,
            purchased: document.querySelector('input[name="purchased"]:checked').value,
            f_nb_results: document.querySelector('input[name="f_nb_results"]:checked').value,
        }).then(response => {
            if (response.ok) {
                document.getElementById('search_text').classList.remove('border');
                return response.json();
            } else {
                if(response.status == 422) {
                    document.getElementById('search_text').classList.add('border');
                    document.getElementById('search_text').classList.add('border-red-500');
                }
                return null;
            }
        }).then(video_games => {
            document.getElementById('content_results').innerHTML = video_games.html;
            if(video_games === null) return;
            document.getElementById('nb_results').innerHTML = video_games.nb_results+' Résultat(s)';
        });
    }
    
    document.querySelector('#check_all_vg_supports').addEventListener('change', (event) => {
        Array.from(document.getElementsByClassName('filter_vg_support')).forEach(el => {
            el.checked = !event.target.checked;
        });
    });

    document.forms['search_video_games'].onsubmit = (e) => {
        e.preventDefault();
        document.getElementById('page').value = 1;
        search_video_games();
    }

    window.addEventListener('scroll', () => {
        if(window.scrollY >= '40') document.getElementById('result_bar').setAttribute('class', 'sticky_search_bar on');
        else document.getElementById('result_bar').setAttribute('class', 'sticky_search_bar off');
    });
</script>
@endsection

@section('content')
    <form id="search_video_games">
        <div class="sticky_search_bar off" id="result_bar">
            <h4 class="font-medium" id="nb_results"></h4>
            @include('partials.video_games.search_bar', ['sortBy' => $sortBy])
        </div>
        
        <hr class="mt-2"/>
        @include('partials.video_games.filter')
    </form>
    
    <div id="content_results">
    </div>
    <input type="hidden" id="page" name="cur_page" value="{{ $paginator->cur_page }}">
    <input type="hidden" id="url" name="url" value="{{ Request::path() }}">
@endsection