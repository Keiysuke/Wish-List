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
        <script src="{{ asset('js/app.js') }}"></script>
        <script src="{{ asset('js/custom.js') }}"></script>
    </head>
    @yield('css')
    <body id="top-page" class="scrollbar-thin scrollbar-track-gray-400 scrollbar-thumb-gray-700">
        @yield('absolute_content')

        @include('partials.header')
        
        <div id="page-container">
            <main id="main" role="main">
                @yield('breadcrumbs')
                @yield('content')
            </main>
        </div>

        <x-btnTopPage/>

        @include('partials.footer')
    </body>
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>
    <script type="text/javascript" src="{{ URL::asset('js/my_notyf.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/my_fetch.js') }}"></script>
    <script>
        $(document).ready(function () { bsCustomFileInput.init() })
        
        window.addEventListener('scroll', btnGoUp);
        function btnGoUp(){
            if(window.scrollY >= '1') document.getElementById('btn-go-up').classList.add('show');
            else document.getElementById('btn-go-up').classList.remove('show');
        }

        function openSearch(on = true){
            if(on){
                document.getElementById('fast-search-text').classList.add('focus-search');
            }else{
                var is_focused = document.activeElement === document.getElementById('fast-search-text');
                if(document.getElementById('fast-search-text').value === '' && !is_focused)
                    document.getElementById('fast-search-text').classList.remove('focus-search');
            }
        }

        function submenu(show, nav){
            if(show) document.getElementById('submenu-' + nav).classList.toggle('open');
            else document.getElementById('submenu-' + nav).classList.remove('open');
            //document.getElementById('submenu-'+nav).classList.toggle('open')
        }
        
        $('#icon-profil').click(function(event){
            event.stopPropagation();
            closeSubmenu('bell');

            if(document.getElementById('subicon-user').classList.contains('open')){
                document.getElementById('subicon-user').classList.remove('open');
                document.getElementById('icon-profil').classList.remove('on');
                document.getElementById('subicon-user').classList.add('close');
            }else{
                document.getElementById('subicon-user').classList.add('open');
                document.getElementById('icon-profil').classList.add('on');
                document.getElementById('subicon-user').classList.remove('close');
            }
        });
        
        $('#icon-bell').click(function(event){
            event.stopPropagation();
            closeSubmenu('user');

            if(document.getElementById('subicon-bell').classList.contains('open-v')){
                document.getElementById('subicon-bell').classList.remove('open-v');
                document.getElementById('icon-bell').classList.remove('on');
                document.getElementById('subicon-bell').classList.add('close-v');
            }else{
                document.getElementById('subicon-bell').classList.add('open-v');
                document.getElementById('icon-bell').classList.add('on');
                document.getElementById('icon-bell').classList.remove('bounce-effect');
                document.getElementById('subicon-bell').classList.remove('close-v');
            }
        });

        $('html').click(function(e) {
            closeSubmenu('user');
            closeSubmenu('bell');
        });

        function closeSubmenu(menu){
            if(menu === 'user'){
                if(document.getElementById('subicon-user').classList.contains('open')){
                    document.getElementById('subicon-user').classList.remove('open');
                    document.getElementById('icon-profil').classList.remove('on');
                    document.getElementById('subicon-user').classList.add('close');
                }
            }else if(menu === 'bell'){
                if(document.getElementById('subicon-bell').classList.contains('open-v')){
                    document.getElementById('subicon-bell').classList.remove('open-v');
                    document.getElementById('icon-bell').classList.remove('on');
                }
            }
        }

        let SIDEBAR = {
            'icon-star': 'left-sidebar-websites',
            'icon-help': 'left-sidebar-help',
            'icon-globe': 'left-sidebar-externals',
        };

        for (var icon in SIDEBAR) { //Gestion de left sidebar
            document.getElementById(''+icon).addEventListener('click', (event) => {
                let icon_clicked = event.target.closest('[data-type="ls_icon"]').id;
                for (var o_icon in SIDEBAR) {
                    if (icon_clicked === o_icon) document.getElementById(''+icon_clicked).classList.toggle('active');
                    else document.getElementById(''+o_icon).classList.remove('active');
                    let content = SIDEBAR[icon_clicked];
                    let o_content = SIDEBAR[o_icon];
                    if (content === o_content) document.getElementById(''+content).classList.toggle('open');
                    else document.getElementById(''+o_content).classList.remove('open');
                };
            });
        };

        function lsBenefitHelp(){
            myFetch('{{ route('simulateBenefit') }}', {method: 'post', csrf: true}, {
                payed: document.getElementById('ls-benefit-payed').value,
                sold: document.getElementById('ls-benefit-sold').value,
                commission: document.getElementById('ls-benefit-commission').checked,
            }).then(response => {
                if (response.ok) return response.json();
            }).then(results => {
                document.getElementById('ls-benefit-results-benef').innerHTML = results.benefit + ' €';
                if (results.benefit >= 0) {
                    document.getElementById('ls-benefit-results-benef').classList.add('text-green-400');
                    document.getElementById('ls-benefit-results-benef').classList.remove('text-red-400');
                } else {
                    document.getElementById('ls-benefit-results-benef').classList.add('text-red-400');
                    document.getElementById('ls-benefit-results-benef').classList.remove('text-green-400');
                }
            });
        }

        function deleteNotif(id) {
            getFetch('notifications/' + id + '/delete')
            .then(results => {
                my_notyf(results);
                document.getElementById('notif' + id).remove();
                document.getElementById('nb-notif').innerHTML -= 1;
                if (document.getElementById('nb-notif').innerHTML == 0) {
                    closeSubmenu('bell');
                }
            });
        }

                                                            /* Friend Requests */
        Array.from(document.getElementsByClassName('friend-request')).forEach(el => { el.addEventListener('click', (el) => {
                const {userId, friendId, answer} = el.target.dataset;
                friendRequest(userId, friendId, answer);
            }); 
        });
        function friendRequest(userId, friendId, answer) {
            getFetch('user/' + userId + '/request/friend/' + friendId + '/' + answer)
            .then(results => {
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