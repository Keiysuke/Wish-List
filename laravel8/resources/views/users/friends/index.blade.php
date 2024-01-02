@extends('template')

@section('metas')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('breadcrumbs')
    {{ Breadcrumbs::render('my_friends') }}
@endsection

@section('js')
<script type="text/javascript" src="{{ URL::asset('js/my_fetch.js') }}"></script>
<script>
    Array.from(document.getElementById('sbh_friends_icons').children).forEach(el => { el.addEventListener('click', setFriendsTab); });

    function setFriendsTab(e = null) {
        const tab = (e) ? e.target.dataset.kind : 'friends';
        switch (tab) {
            case 'friends': search_user();
                break;
            case 'users': search_user(false);
                break;
            case 'my_params':
                break;
        }
        document.getElementById('sbh_friends_icons').dataset.current = tab;
    }

    function closeUserProfile() {
        document.getElementById('user_profile').classList.add('hidden');
        document.getElementById('user_profile').classList.remove('flex');
    }

    function showUserProfile(e) {
        const new_id = e.target.dataset.id;
        const w = document.getElementById('user_profile');
        if (new_id == w.dataset.userId || w.dataset.userId == 0) {
            w.classList.toggle('hidden');
            w.classList.toggle('flex');
        }
        w.dataset.userId = new_id;
        //On actualise seulement lorsqu'on affiche un autre user
        if (w.classList.contains('flex')) {
            my_fetch('{{ route('get_user_profile') }}', {method: 'post', csrf: true}, {
                user_id: parseInt(new_id),
            }).then(response => {
                if (response.ok) return response.json();
            }).then(results => {
                document.getElementById('user_datas').innerHTML = results.html;
                if (results.is_friend) {
                    document.getElementById('delete_friend').addEventListener('click', removeFriend);
                    document.getElementById('add_on_list').addEventListener('click', showSharedLists);

                } else {
                    document.getElementById('add_friend').addEventListener('click', addFriend);
                }
            });
        }
    }
    
    function showSharedLists(e) {

    }

    function addFriend(e) {
        my_fetch('{{ route('friend_requesting') }}', {method: 'post', csrf: true}, {
            friend_id: parseInt(e.target.dataset.id),
        }).then(response => {
            if (response.ok) return response.json();
        }).then(results => {
            if (results.notyf) {
                var notyf = new Notyf();
                notyf.open(results.notyf);
            }
        });
    }
    
    function removeFriend(e) {
        my_fetch('{{ route('remove_friend') }}', {method: 'post', csrf: true}, {
            friend_id: parseInt(e.target.dataset.id),
        }).then(response => {
            if (response.ok) return response.json();
        }).then(results => {
            if (results.notyf) {
                var notyf = new Notyf();
                notyf.open(results.notyf);
            }
            if (results.success) {
                closeUserProfile()
                document.getElementById('sb_friend_row_' + results.user_id).remove();
            }
        });
    }

    function search_user(is_friend = true){
        my_fetch('{{ route('friends_search') }}', {method: 'post', csrf: true}, {
            name: document.getElementById('search_user').value,
            is_friend: is_friend,
        }).then(response => {
            if (response.ok) {
                document.getElementById('search_user').classList.remove('border');
                return response.json();
            } else {
                if(response.status == 422) {
                    document.getElementById('search_user').classList.add('border');
                    document.getElementById('search_user').classList.add('border-red-500');
                }
                return null;
            }
        }).then(friends => {
            document.getElementById('friends_content_results').innerHTML = friends.html;
            Array.from(document.getElementsByClassName('friend_row')).forEach(el => { el.addEventListener('click', showUserProfile); });
            if(friends === null) {
                document.getElementById('title_friends_content_results').innerHTML = 'Aucun résultat';
            } else {
                document.getElementById('title_friends_content_results').innerHTML = is_friend ? 'Mes amis (' + friends.nb_results + ')' : 'Ajouter des amis';
            }
        });
    }

    document.getElementById('close_user_profile').addEventListener('click', closeUserProfile);
    setFriendsTab();
</script>
@endsection

@section('content')
<div id="wrap_sidebar_friends">
    <div id="sidebar_friends">
        <div id="sb_head_friends">
            <div id="sbh_friends_icons" data-current="friends">
                <x-svg.users class="icon-sm" data-kind="friends"/>
                <x-svg.user_plus class="icon-sm" data-kind="users"/>
                <x-svg.plus class="icon-sm" data-kind="my_params"/>
            </div>
            <div id="content_search_user">
                <input type="text" class=" p-2 w-11/12 pr-8" placeholder="{{ __('Search users...') }}" id="search_user" name="search_user" onKeyUp="search_user();" value="">
                <button type="submit" class="absolute mt-3 mr-2">
                    <x-svg.search class="icon-xs text-gray-400 pt-1 pr-1"/>
                </button>
            </div>
            <div id="friends_list">
                <h2 id="title_friends_content_results"></h2>
                <div id="friends_content_results">
                </div>
            </div>
        </div>
    </div>

    <div id="user_profile" class="hidden" data-user-id="0">
        <div id="close_user_profile" class="btn_close icon-clickable">
            <x-svg.close class="btn_clickable icon-sm" />
        </div>
        <div id="user_datas">
        </div>
    </div>
</div>
@endsection