<x-app-layout>
    @section('css')
        <link rel="stylesheet" href="{{ asset('css/admin/design_system.css') }}">
    @endsection

    @section('js')
        <script type="text/javascript" src="{{ URL::asset('js/my_notyf.js') }}"></script>
        <script type="text/javascript" src="{{ URL::asset('js/my_fetch.js') }}"></script>
    @endsection

    <div id="dashboard-table">
        <x-admin.dashboard_menu menu="design" sub="system"/>
        
        <div class="right pb-20">
            @include("partials.admin.design_system.icons", $icons)
            @include("partials.admin.design_system.notifs", compact('notifications', 'notyfs'))
            @include("partials.admin.design_system.form", $colors)
        </div>
    </div>
</x-app-layout>
