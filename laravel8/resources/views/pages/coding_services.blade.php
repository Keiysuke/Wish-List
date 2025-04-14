<x-app-layout>
    @section('css')
        <link rel="stylesheet" href="{{ asset('css/admin/design_system.css') }}">
    @endsection

    @section('js')
        <script type="text/javascript" src="{{ URL::asset('js/my_notyf.js') }}"></script>
    @endsection

    <div id="dashboard-table">
        <x-admin.dashboard_menu menu="design" sub="coding_services"/>
        
        <div class="right pb-20">
            @include("partials.admin.coding.services")
        </div>
    </div>
</x-app-layout>