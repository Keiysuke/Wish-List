<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Wish list - Garder une trace de vos achats & re/ventes</title>
        <meta name="description" content="Ce site vous permet de gérer vos achats et ventes effectués sur Internet.">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        @yield('metas')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/custom_app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/header.css') }}" rel="stylesheet">
        <link href="{{ asset('css/footer.css') }}" rel="stylesheet">
        <link href="{{ asset('css/sidebar.css') }}" rel="stylesheet">
        <link href="{{ asset('css/sidebar_friends.css') }}" rel="stylesheet">
        <link href="{{ asset('css/my_templates/'.($kind ?? 'default').'.css') }}" rel="stylesheet">
        <script src="{{ asset('js/custom.js') }}"></script>
    </head>
    @yield('css')
    <body id="top_page" class="my_scrollbar">
        @yield('absolute_content')

        @include('partials.header')
        
        <div id="page-container">
            <main id="main" role="main">
                @yield('breadcrumbs')
                @yield('content')
            </main>
        </div>

        <x-btn-top-page/>

        @include('partials.footer')
    </body>
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>
    <script type="text/javascript" src="{{ URL::asset('js/my_fetch.js') }}"></script>
    <script>
        $(document).ready(function () { bsCustomFileInput.init() })
        
        window.addEventListener('scroll', btnGoUp);
        function btnGoUp(){
            if(window.scrollY >= '1') document.getElementById('btn-go-up').classList.add('show');
            else document.getElementById('btn-go-up').classList.remove('show');
        }

        function open_search(on = true){
            if(on){
                document.getElementById('fast_search_text').classList.add('focus_search');
            }else{
                var is_focused = document.activeElement === document.getElementById('fast_search_text');
                if(document.getElementById('fast_search_text').value === '' && !is_focused)
                    document.getElementById('fast_search_text').classList.remove('focus_search');
            }
        }

        function submenu(show, nav){
            if(show) document.getElementById('submenu_'+nav).classList.toggle('open');
            else document.getElementById('submenu_'+nav).classList.remove('open');
            //document.getElementById('submenu_'+nav).classList.toggle('open')
        }
        
        $('#icon-profil').click(function(event){
            event.stopPropagation();
            close_submenu('bell');

            if(document.getElementById('subicon_user').classList.contains('open')){
                document.getElementById('subicon_user').classList.remove('open');
                document.getElementById('icon-profil').classList.remove('on');
                document.getElementById('subicon_user').classList.add('close');
            }else{
                document.getElementById('subicon_user').classList.add('open');
                document.getElementById('icon-profil').classList.add('on');
                document.getElementById('subicon_user').classList.remove('close');
            }
        });
        
        $('#icon-bell').click(function(event){
            event.stopPropagation();
            close_submenu('user');

            if(document.getElementById('subicon_bell').classList.contains('open-v')){
                document.getElementById('subicon_bell').classList.remove('open-v');
                document.getElementById('icon-bell').classList.remove('on');
                document.getElementById('subicon_bell').classList.add('close-v');
            }else{
                document.getElementById('subicon_bell').classList.add('open-v');
                document.getElementById('icon-bell').classList.add('on');
                document.getElementById('icon-bell').classList.remove('bounce-effect');
                document.getElementById('subicon_bell').classList.remove('close-v');
            }
        });

        $('html').click(function(e) {
            close_submenu('user');
            close_submenu('bell');
        });

        function close_submenu(menu){
            if(menu === 'user'){
                if(document.getElementById('subicon_user').classList.contains('open')){
                    document.getElementById('subicon_user').classList.remove('open');
                    document.getElementById('icon-profil').classList.remove('on');
                    document.getElementById('subicon_user').classList.add('close');
                }
            }else if(menu === 'bell'){
                if(document.getElementById('subicon_bell').classList.contains('open-v')){
                    document.getElementById('subicon_bell').classList.remove('open-v');
                    document.getElementById('icon-bell').classList.remove('on');
                }
            }
        }

        let SIDEBAR = {
            'icon-star': 'left_sidebar_websites',
            'icon-help': 'left_sidebar_help',
            'icon-globe': 'left_sidebar_externals',
        };

        for (var icon in SIDEBAR) { //Gestion de left sidebar
            document.querySelector('#'+icon).addEventListener('click', (event) => {
                let icon_clicked = event.target.closest('[data-type="ls_icon"]').id;
                for (var o_icon in SIDEBAR) {
                    if (icon_clicked === o_icon) document.querySelector('#'+icon_clicked).classList.toggle('active');
                    else document.querySelector('#'+o_icon).classList.remove('active');
                    let content = SIDEBAR[icon_clicked];
                    let o_content = SIDEBAR[o_icon];
                    if (content === o_content) document.querySelector('#'+content).classList.toggle('open');
                    else document.querySelector('#'+o_content).classList.remove('open');
                };
            });
        };

        function ls_benefit_help(){
            my_fetch('{{ route('simulate_benefit') }}', {method: 'post', csrf: true}, {
                payed: document.querySelector('#ls_benefit_payed').value,
                sold: document.querySelector('#ls_benefit_sold').value,
                commission: document.querySelector('#ls_benefit_commission').checked,
            }).then(response => {
                if (response.ok) return response.json();
            }).then(results => {
                document.querySelector('#ls_benefit_results_benef').innerHTML = results.benefit + ' €';
                if (results.benefit >= 0) {
                    document.querySelector('#ls_benefit_results_benef').classList.add('text-green-400');
                    document.querySelector('#ls_benefit_results_benef').classList.remove('text-red-400');
                } else {
                    document.querySelector('#ls_benefit_results_benef').classList.add('text-red-400');
                    document.querySelector('#ls_benefit_results_benef').classList.remove('text-green-400');
                }
            });
        }

        function deleteNotif(id) {
            my_fetch('notifications/' + id + '/delete', {method: 'get'}
            ).then(response => {
                if (response.ok) return response.json();
            }).then(results => {
                my_notyf(results);
                document.getElementById('notif_' + id).remove();
                document.getElementById('nb_notifs').innerHTML -= 1;
            });
        }

                                                            /* Friend Requests */

        Array.from(document.getElementsByClassName('accept_friend_request')).forEach(el => { el.addEventListener('click', acceptFriendRequest); });
        Array.from(document.getElementsByClassName('delete_friend_request')).forEach(el => { el.addEventListener('click', deleteFriendRequest); });
        function acceptFriendRequest(e) {
            my_fetch('{{ route('friend_request_end', ['status' => 'accept']) }}', {method: 'post', csrf: true}, {
                user_id: parseInt(e.target.dataset.userId),
                friend_id: parseInt(e.target.dataset.friendId),
            }).then(response => {
                if (response.ok) return response.json();
            }).then(results => {
                my_notyf(results);
            });
        }

        function deleteFriendRequest(e) {
            my_fetch('{{ route('friend_request_end', ['status' => 'delete']) }}', {method: 'post', csrf: true}, {
                user_id: parseInt(e.target.dataset.userId),
                friend_id: parseInt(e.target.dataset.friendId),
            }).then(response => {
                if (response.ok) return response.json();
            }).then(results => {
                my_notyf(results);
            });
        }
        
        /* Friend Requests on a list */
        
        Array.from(document.getElementsByClassName('join_friend_list')).forEach(el => { el.addEventListener('click', joinFriendList); });
        Array.from(document.getElementsByClassName('unjoin_friend_list')).forEach(el => { el.addEventListener('click', unjoinFriendList); });
        function joinFriendList(e) {
            my_fetch('{{ route('join_friend_list_request_end', ['status' => 'accept']) }}', {method: 'post', csrf: true}, {
                user_id: parseInt(e.target.dataset.userId),
                list_id: parseInt(e.target.dataset.listId),
            }).then(response => {
                if (response.ok) return response.json();
            }).then(results => {
                my_notyf(results);
            });
        }

        function unjoinFriendList(e) {
            console.log(e.target.dataset);
            my_fetch('{{ route('join_friend_list_request_end', ['status' => 'delete']) }}', {method: 'post', csrf: true}, {
                user_id: parseInt(e.target.dataset.userId),
                list_id: parseInt(e.target.dataset.listId),
            }).then(response => {
                if (response.ok) return response.json();
            }).then(results => {
                my_notyf(results);
            });
        }

        //We stop the propagation of an event for each element that has the class "no-propagate"
        Array.from(document.getElementsByClassName('no-propagate')).forEach(el => { el.addEventListener('click', stopPropagate); });
        function stopPropagate(e){ e.stopPropagation(); }
    </script>
    @yield('js')
    @stack('scripts')
</html>