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
<script>
    search_products();

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
        search_products();
    }
    function toggle_archived(){
        show = document.getElementById('show_archived');
        document.getElementById('show_archived').value = (show.value == 0)? 1 : 0;
        document.getElementById('title_show_archived').title = (show.value == 0)? "{{ __('Show archived') }}" : "{{ __('Hide archived') }}";
        document.getElementById('icon_show_archived').classList.toggle('active');
        search_products();
    }
    function display_result(kind){
        document.getElementById('result_icon_list').classList.toggle('hidden');
        document.getElementById('result_icon_grid').classList.toggle('hidden');
        document.getElementById('list').value = (kind === 'list')? 'list' : 'grid';
        document.getElementById('icon_list').title = (kind === 'list')? 'Liste' : 'Grille';
        search_products();
    }
    function change_page(nb){
        document.getElementById('page').value = nb;
        search_products();
    }

    function search_products(){
        let websites = Array();
        let tags = Array();
        Array.from(document.getElementsByClassName('filter_website')).forEach(el => {
            if(el.checked) websites.push(el.name);
        });
        Array.from(document.getElementsByClassName('filter_tag')).forEach(el => {
            if(el.checked) tags.push(el.name);
        });
        
        my_fetch('{{ route('products_search') }}', {method: 'post', csrf: true}, {
            search_text: document.getElementById('search_text').value,
            sort_by: document.getElementById('sort_by').value,
            order_by: document.getElementById('order_by').value,
            list: document.getElementById('list').value,
            show_archived: document.getElementById('show_archived').value,
            page: document.getElementById('page').value,
            url: document.getElementById('url').value,
            websites: websites,
            no_tag: document.getElementById('no_tag').checked,
            exclusive_tags: document.getElementById('exclusive_tags').checked,
            tags: tags,
            purchased: document.querySelector('input[name="purchased"]:checked').value,
            stock: document.querySelector('input[name="stock"]:checked').value,
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
        }).then(products => {
            document.getElementById('content_results').innerHTML = products.html;
            if(products === null) return;
            document.getElementById('nb_results').innerHTML = products.nb_results+' Résultat(s)';
        });
    }

    document.forms['search_products'].onsubmit = (e) => {
        e.preventDefault();
        document.getElementById('page').value = 1;
        search_products();
    }

    window.addEventListener('scroll', () => {
        if(window.scrollY >= '40') document.getElementById('result_bar').setAttribute('class', 'sticky_search_bar on');
        else document.getElementById('result_bar').setAttribute('class', 'sticky_search_bar off');
    });

    document.querySelector('#check_all_websites').addEventListener('change', (event) => {
        Array.from(document.getElementsByClassName('filter_website')).forEach(el => {
            el.checked = !event.target.checked;
        });
    });

    document.querySelector('#check_all_tags').addEventListener('change', (event) => {
        Array.from(document.getElementsByClassName('filter_tag')).forEach(el => {
            el.checked = !event.target.checked;
        });
    });
</script>
@endsection

@section('content')
    <form id="search_products">
        <div class="sticky_search_bar off" id="result_bar">
            <h4 class="font-medium" id="nb_results"></h4>
            @include('partials.products.search_bar', ['sortBy' => $sortBy])
        </div>
        
        <hr class="mt-2"/>
        @include('partials.filters.products')
    </form>
    
    <div id="content_results">
    </div>
    <input type="hidden" id="page" name="cur_page" value="{{ $paginator->cur_page }}">
    <input type="hidden" id="url" name="url" value="{{ Request::path() }}">
@endsection