@extends('template')

@section('metas')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('breadcrumbs')
    {{ Breadcrumbs::render('list', 'list') }}
@endsection

@section('css')
    <link href="{{ asset('css/list_products.css') }}" rel="stylesheet">
@endsection
@section('js')
<script type="text/javascript" src="{{ URL::asset('js/my_fetch.js') }}"></script>
<script type="text/javascript">
    function toggle_filters(){
        document.querySelector('#content_filters').classList.toggle('hidden');
    }

    Array.from(document.getElementsByClassName('delete_list')).forEach(e => {
        e.addEventListener('click', (e) => {
            my_fetch('{{ route('destroy_list') }}', {method: 'post', csrf: true}, {
                id: e.target.dataset.list_id
            }).then(response => {
                if (response.ok) return response.json();
            }).then(res => {
                document.querySelector("#list_"+res.deleted_id).remove();
                if(res.list_id > 0) document.onload = get_products(res.list_id); //There's still one other list
                else{ //No more list for the user
                    document.querySelector("#my_lists").innerHTML = "<span>Vous n'avez pas encore créé de liste...</span>";
                }
            });
        });
    });

    function toggle_list(list_id, product_id){
            my_fetch('{{ route('toggle_product_on_list') }}', {method: 'post', csrf: true}, {
            list_id: list_id,
            product_id: product_id,
            change_checked:true
        }).then(response => {
            if (response.ok) return response.json();
        }).then(res => {
            document.querySelector("#list_"+list_id+"_product_"+product_id).remove();
            let nb_results = document.querySelector('#nb_results').getAttribute('data-nb')-1;
            if(nb_results > 0){
                document.querySelector('#nb_results').setAttribute('data-nb', nb_results);
                document.querySelector('#nb_results').innerHTML = nb_results+' Résultat(s)';
                document.querySelector('#total_price').innerHTML = 'Montant total : ' + res.total_price + ' €';
            }else get_products(list_id);
        });
    }

    function get_products(list_id){
        my_fetch('{{ route('show_list_products') }}', {method: 'post', csrf: true}, {
            list_id: list_id
        }).then(response => {
            if (response.ok) return response.json();
        }).then(products => {
            if(document.querySelector('#list_selected').value != '' && document.querySelector('#list_'+document.querySelector('#list_selected').value) != undefined)
                document.querySelector('#list_'+document.querySelector('#list_selected').value).classList.toggle('selected');
            document.querySelector('#list_selected').value = list_id;
            document.querySelector('#list_'+list_id).classList.toggle('selected');
            document.querySelector('#content_results').innerHTML = products.html;
        });
    }
    document.onload = get_products({{ empty($lists->first())? 0 : $lists->first()->id }});
</script>
@endsection

@section('content')
    <x-notification type="success" msg="{{ session('info') }}"/>

    <div id="content_lists" class="flex-col h-4/5">
        <div class="w-full relative flex justify-between border-b-2 mb-2">
            <div class="flex align-start gap-1">
                <x-svg.clipboard_list class="w-7"/>
                <h2>Mes listes</h2>
            </div>
            
            <div class="absolute right-0 -top-1">
                <a title="Nouvelle liste" href="{{ route('lists.create') }}" class="title-icon inline-flex">
                    <x-svg.plus class="icon-xs"/>
                </a>
                <span onClick="toggle_filters();">
                    <span class="title-icon cursor-pointer inline-flex">
                        <x-svg.filter class="icon-xs"/>
                    </span>
                </span>
            </div>
        </div>

        <form id="filter_historic">
            @include("partials.lists.filter")
        </form>
        
        <input id="list_selected" type="hidden" value=""/>
        <div id="my_lists" class="flex justify-center h-full gap-2 divide-x-2 mt-4">
            @if(count($lists) === 0)
            <span>Vous n'avez pas encore créé de liste...</span>
            @else
                <div id="left" class="w-1/5 flex flex-col gap-2">
                    @foreach ($listing_types as $listing_type_id => $lists)
                    <div id="list_type_{{ $listing_type_id }}" class="list_type">
                        @php($listing_type = \App\Models\ListingType::find($listing_type_id))
                        <div class="label">{{ $listing_type->label }}</div>
                        <div id="content_list_type_{{ $listing_type_id }}" class="all_lists">
                        @foreach ($lists as $list)
                            <div id="list_{{ $list->id }}" class="flex w-full gap-2 cursor-pointer text-sm">
                                <div class="flex w-full justify-between hover:text-red-500 hover:underline" onClick="get_products({{ $list->id }});">
                                    <span class="inline-flex">{{ $list->label }}
                                        @if($list->secret)
                                            <x-svg.big.gift class="icon-xs ml-1 text-red-400"/>
                                        @endif
                                    </span>
                                    <span class="font-light">{{ !$list->users? 'Partagée' : 'Privée' }}</span>
                                </div>
                                <a title="Editer la liste" href="{{ route('lists.edit', $list->id) }}">
                                    <x-svg.edit class="icon-xs icon-clickable"/>
                                </a>
                                <x-svg.trash title="Supprimer la liste ?" class="delete_list icon-xs icon-clickable hover:text-red-600" data-list_id="{{ $list->id }}"/>
                            </div>
                        @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div id="right" class="w-4/5 flex-col gap-1 px-3 -mt-2">
                    <div id="content_results">
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection