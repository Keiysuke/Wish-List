<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Wish list - Garder une trace de vos achats & re/ventes</title>
        <meta name="description" content="Ce site vous permet de gérer vos achats et ventes effectués sur Internet.">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        @yield('metas')
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/custom_app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/header.css') }}" rel="stylesheet">
        <link href="{{ asset('css/footer.css') }}" rel="stylesheet">
        <script src="{{ asset('js/custom.js') }}"></script>
    </head>
    @yield('css')
    <body id="top_page" class="scrollbar-thin scrollbar-thumb-gray-700 scrollbar-track-gray-400">
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
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>
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

        //We stop the propagation of an event for each element that has the class "no-propagate"
        Array.from(document.getElementsByClassName('no-propagate')).forEach(el => { el.addEventListener('click', stopPropagate); });
        function stopPropagate(e){ e.stopPropagation(); }
    </script>
    @yield('js')
    @stack('scripts')
</html>