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
<script type="text/javascript" src="{{ URL::asset('js/my_notyf.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/my_fetch.js') }}"></script>
<script type="text/javascript">
    function toggle_filters(){
        document.getElementById('content_filters').classList.toggle('hidden');
    }

    Array.from(document.getElementsByClassName('delete_list')).forEach(e => {
        e.addEventListener('click', (e) => {
            const id = e.target.dataset.list_id;
            get_fetch('lists/' + id + '/destroy')
            .then(res => {
                document.getElementById("list_"+res.deleted_id).remove();
                my_notyf(res);
                if(res.list_id > 0) document.onload = get_products(res.list_id); //There's still one other list
                else{ //No more list for the user
                    document.getElementById("my_lists").innerHTML = "<span>Vous n'avez pas encore créé de liste...</span>";
                }
            });
        });
    });

    function leave_list(list_id){
        get_fetch('lists/' + list_id + '/leave')
        .then(res => {
            if (res.success) location.reload();
        });
    }
    
    function download_list(list_id){
        get_fetch('lists/' + list_id + '/download')
        .then(res => {
            let link = document.createElement('a');
            link.href = window.URL.createObjectURL(new Blob([res.blob]));
            link.setAttribute('download', res.filename + '.csv');
            document.body.appendChild(link);
            link.click();
        });
    }
    
    function toggleShareList(list_id){
        event.stopPropagation();
        document.getElementById('content_share_lists').classList.toggle('hidden');
        document.getElementById('content_share_lists').classList.toggle('flex');
        document.getElementById('main').classList.toggle('pointer-events-none');
    }

    function showShareList(list_id){
        get_fetch('shared/lists/' + list_id + '/show')
        .then(res => {
            if (res.success) {
                document.getElementById('content_share_lists').innerHTML = res.html;
                document.getElementById('content_share_lists').classList.toggle('hidden');
                document.getElementById('content_share_lists').classList.toggle('flex');
                document.getElementById('main').classList.toggle('pointer-events-none');
            }
        });
    }

    function shareList(list_id){
        event.stopPropagation();
        let friends = Array();
        Array.from(document.querySelectorAll('[name^="share_friend_"]')).forEach(el => {
            if(el.checked) friends.push(parseInt(el.dataset.friendId));
        });
        if (friends.length === 0) {
            notyfJS('Veuillez sélectionner au moins l\'un de vos amis', 'error');
            return;
        }
        my_fetch('{{ route('share_list') }}', {method: 'post', csrf: true}, {
            list_id: parseInt(list_id),
            friends: friends,
        }).then(response => {
            if (response.ok) return response.json();
        }).then(res => {
            my_notyf(res);
            if (res.success) {
                document.getElementById('content_share_lists').classList.toggle('flex');
                document.getElementById('content_share_lists').classList.toggle('hidden');
                document.getElementById('main').classList.toggle('pointer-events-none');
            }
        });
    }
    
    function del_list_msg(id) {
        event.stopPropagation();
        if(confirm('Confirmer la suppression ?')) {
            const list_id = document.getElementById('list_selected').value;
            let url = (id == 0) ? 'lists/' + list_id + '/delete/messages' : 'lists/messages/' + id + '/delete';
            get_fetch(url)
            .then(res => {
                my_notyf(res);
                if (res.html) {
                    document.getElementById('messages_content').innerHTML = res.html;
                } else {
                    document.getElementById('list_msg_' + id).remove();
                }
            });
        }
    }

    function show_lists(user_id) {
        const old_user_id = document.getElementById('lists_user_id').value;
        if (old_user_id == user_id) return;
        
        if (user_id == 0) {
            document.getElementById('title_others_lists').classList.add('active');
            document.getElementById('title_my_lists').classList.remove('active');
        } else {
            document.getElementById('title_others_lists').classList.remove('active');
            document.getElementById('title_my_lists').classList.add('active');
        }

        document.getElementById('lists_user_id').value = user_id;
        get_fetch('lists/users/' + user_id)
        .then(lists => {
            document.getElementById('wrap_lists').innerHTML = lists.html;
            get_products(lists.first_list_id);
        });
    }

    function show_messages(res) {
        const messages_content = document.getElementById('messages_content');
        const wrap_list_products = document.getElementById('wrap_list_products');
        if (res.messages_html !== null && res.shared_list) {
            messages_content.innerHTML = res.messages_html;
            messages_content.classList.remove('hidden');
            wrap_list_products.classList.remove('extend');
            wrap_list_products.classList.add('with_msg');
            
            document.getElementById('v_list_msg').scrollTop = document.getElementById('v_list_msg').scrollHeight;
        } else if (!messages_content.classList.contains('hidden')) {
            wrap_list_products.classList.remove('with_msg');
            wrap_list_products.classList.add('extend');
            messages_content.classList.add('hidden');
        }
    }

    function extendListMsg(reset = false) {
        const msg_content = document.getElementById('messages_content');
        const wrap_list_products = document.getElementById('wrap_list_products');
        if (reset) {
            msg_content.classList.remove('extend');
            wrap_list_products.classList.remove('with_msg');
        } else {
            msg_content.classList.toggle('extend');
            wrap_list_products.classList.toggle('with_msg');
        }
    }

    function send_msg() {
        my_fetch('{{ route('send_message') }}', {method: 'post', csrf: true}, {
            listing_id: parseInt(document.getElementById('list_selected').value),
            message: document.getElementById('list_msg_to_send').value,
            answer_to_id: parseInt(document.getElementById('list_answer_id').value),
        }).then(response => {
            if (response.ok) return response.json();
        }).then(res => {
            document.getElementById('v_list_msg').insertAdjacentHTML('beforeend', res.message);
            document.getElementById('list_msg_to_send').value = '';

            if (document.getElementById('list_answer_id').value > 0) {
                cancelReply();
            }
        });
    }

    function replyTo(id, name) {
        document.getElementById('list_answer_to').classList.remove('hidden');
        document.getElementById('list_answer_to').firstElementChild.innerHTML = name;
        document.getElementById('list_answer_id').value = id;
        document.getElementById('list_msg_' + id).classList.add('answering');
    }
    
    function cancelReply() {
        const answer_id = document.getElementById('list_answer_id').value;
        document.getElementById('list_answer_to').classList.add('hidden');
        document.getElementById('list_answer_id').value = 0;
        document.getElementById('list_msg_' + answer_id).classList.remove('answering');
    }
    
    function pin_msg(id) {
        const pin_msg = document.getElementById('pin_msg_icon_' + id);
        const action = pin_msg.classList.contains('is_pin') ? 'unpin' : 'pin';
        get_fetch('lists/messages/' + id + '/' + action)
        .then(res => {
            pin_msg.classList[(action == 'pin' ? 'add' : 'remove')]('is_pin');
            my_notyf(res);
        });
    }
    
    function show_msg() {
        const list_id = document.getElementById('list_selected').value;
        const show_pin = !document.getElementById('show_pin').classList.contains('active');
        const type = show_pin ? 'pinned' : 'all';
        get_fetch('lists/' + list_id + '/messages/show/' + type)
        .then(res => {
            document.getElementById('v_list_msg').innerHTML = res.html;
            document.getElementById('show_pin').classList.toggle('active');
        });
    }

    function flashOriginalMsg(id) {
        const msg = document.getElementById('list_msg_' + id);
        msg.classList.add('flash');
        setTimeout(() => { msg.classList.remove('flash'); }, 1500);
    }

    function toggle_list(list_id, product_id){
        my_fetch('{{ route('toggle_product_on_list') }}', {method: 'post', csrf: true}, {
            list_id: parseInt(list_id),
            product_id: parseInt(product_id),
            change_checked:true
        }).then(response => {
            if (response.ok) return response.json();
        }).then(res => {
            document.getElementById("list_"+list_id+"_product_"+product_id).remove();
            let nb_results = document.getElementById('nb_results').getAttribute('data-nb')-1;
            if(nb_results > 0){
                document.getElementById('nb_results').setAttribute('data-nb', nb_results);
                document.getElementById('nb_results').innerHTML = nb_results+' Résultat(s)';
                document.getElementById('total_price').innerHTML = 'Montant total : ' + res.total_price + ' €';
            }else get_products(list_id);
        });
    }

    function get_products(list_id){
        const old_list_id = document.getElementById('list_selected').value;
        if (old_list_id == list_id) return;

        get_fetch('lists/' + list_id + '/products/show')
        .then(products => {
            if(document.getElementById('list_selected').value != '' && document.getElementById('list_'+document.getElementById('list_selected').value) != undefined)
                document.getElementById('list_'+document.getElementById('list_selected').value).classList.toggle('selected');
            document.getElementById('list_selected').value = list_id;
            document.getElementById('list_'+list_id).classList.toggle('selected');
            document.getElementById('content_results').innerHTML = products.html;
            extendListMsg(true);
            show_messages(products);
        });
    }

    show_lists({{ auth()->user()->id }});
</script>
@endsection

@section('absolute_content')
    <div id="content_share_lists" class="hidden">
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