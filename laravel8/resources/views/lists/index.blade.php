@extends('template')

@section('metas')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('breadcrumbs')
    {{ Breadcrumbs::render('list', 'list') }}
@endsection

@section('css')
    <link href="{{ asset('css/list_products.css') }}" rel="stylesheet">
    <link href="{{ asset('css/lists.css') }}" rel="stylesheet">
@endsection

@section('js')
<script src="{{ asset('js/tchat.js') }}"></script>
<script src="{{ asset('js/listings.js') }}"></script>
<script type="text/javascript">
    show_lists({{ auth()->user()->id }});
</script>
@endsection

@section('absolute_content')
    <div id="content_share_lists" class="hidden">
    </div>
    <div id="list_msg_menu" class="hidden">
    </div>
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
            @include("partials.filters.lists")
        </form>
        
        <input id="list_selected" type="hidden" value=""/>
        <div id="my_lists" class="flex justify-center h-full gap-2 divide-x-2 mt-4">
            @if(count($lists) === 0)
            <span>Vous n'avez pas encore créé de liste...</span>
            @else
                <div id="left" class="w-1/5 flex flex-col gap-2">
                    <div class="flex w-full justify-center gap-1 border-b border-teal-500 mb-2 relative">
                        <input type="hidden" id="lists_user_id"/>
                        <span id="title_my_lists" class="title-text active border-teal-500" onClick="show_lists('{{ auth()->user()->id }}');">
                            <x-svg.clipboard_list title="Mes listes" class="icon-xs"/> Mes listes
                        </span>
                        <span id="title_others_lists" class="title-text border-teal-500" onClick="show_lists('0');">
                            <x-svg.big.user_group title="Listes de mes amis" class="icon-xs"/> Listes d'amis
                        </span>
                    </div>
                    <div id="wrap_lists">
                    </div>
                </div>
                
                <div id="wrap_list_products" class="extend">
                    <div id="content_results">
                    </div>
                </div>
                <div id="messages_content">
                </div>
            @endif
        </div>
    </div>
@endsection