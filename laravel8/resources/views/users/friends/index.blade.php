@extends('template')

@section('metas')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('breadcrumbs')
    {{ Breadcrumbs::render('myFriends') }}
@endsection

@section('js')
<script type="text/javascript" src="{{ URL::asset('js/my_fetch.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/manageFriends.js') }}"></script>
<script>
    Array.from(document.getElementById('sbh-friends-icons').children).forEach(el => { el.addEventListener('click', setFriendsTab); });

    document.getElementById('close-user-profile').addEventListener('click', closeUserProfile);
    setFriendsTab();
</script>
@endsection

@section('content')
<div id="wrap-sidebar-friends">
    <div id="sidebar-friends">
        <div id="sb-friends-head">
            <div id="sbh-friends-icons" data-current="friends">
                <x-svg.users class="icon-sm" data-kind="friends"/>
                <x-svg.user_plus class="icon-sm" data-kind="users"/>
                <x-svg.plus class="icon-sm" data-kind="my_params"/>
            </div>
            <div id="content-search-user">
                <input type="text" class=" p-2 w-11/12 pr-8" placeholder="{{ __('Search users...') }}" id="search-user" name="searchUser" onKeyUp="searchUser();" value="">
                <button type="submit" class="absolute mt-3 mr-2">
                    <x-svg.search class="icon-xs text-gray-400 pt-1 pr-1"/>
                </button>
            </div>
            <div id="friends-list">
                <h2 id="title-friends-content-results"></h2>
                <div id="friends-content-results">
                </div>
            </div>
        </div>
    </div>

    <div id="user-profile" class="hidden" data-user-id="0">
        <div id="close-user-profile" class="btn-close icon-clickable">
            <x-svg.close class="btn_clickable icon-sm" />
        </div>
        <div id="user-datas">
        </div>
    </div>
</div>
@endsection