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
            }else get_products(list_id);
        });
    }

    function get_products(list_id){
        my_fetch('{{ route('show_list_products') }}', {method: 'post', csrf: true}, {
            list_id: list_id
        }).then(response => {
            if (response.ok) return response.json();
        }).then(products => {
            if(document.querySelector('#list_selected').value != '')
                document.querySelector('#list_'+document.querySelector('#list_selected').value).classList.toggle('selected');
            document.querySelector('#list_selected').value = list_id;
            document.querySelector('#list_'+list_id).classList.toggle('selected');
            document.getElementById('content_results').innerHTML = products.html;
        });
    }
    document.onload = get_products({{ $lists->first()->id }});
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
            </div>
        </div>
        
        <input id="list_selected" type="hidden" value=""/>
        <div id="my_lists" class="flex justify-center h-full gap-2 divide-x-2 mt-4">
            @if(count($lists) === 0)
            <span>Vous n'avez pas encore créé de liste...</span>
            @else
                <div id="left" class="w-1/5 flex flex-col gap-2">
                    @foreach ($lists as $list)
                        <div id="list_{{ $list->id }}" class="flex w-full gap-2 cursor-pointer text-sm">
                            <div class="flex w-full justify-between hover:text-red-500 hover:underline" onClick="get_products({{ $list->id }});">
                                <span class="inline-flex">{{ $list->label }}
                                    @if($list->secret)
                                        <x-svg.big.gift class="icon-xs ml-1"/>
                                    @endif
                                </span>
                                <span class="font-light">{{ count($list->users) > 0 ? 'Partagée' : 'Privée' }}</span>
                            </div>
                            <a title="Editer la liste" href="{{ route('lists.edit', $list->id) }}">
                                <x-svg.edit class="icon-xs icon-clickable"/>
                            </a>
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