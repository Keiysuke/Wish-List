<x-app-layout>
    <div id="dashboard-table">
        <x-admin.dashboard_menu menu="database" sub="countries"/>
        
        <div class="right">
            <x-Notification type="success" msg="{{ session('info') }}"/>

            <form class="bg-white rounded px-8 pt-6 pb-8 mb-4" action="{{ route('countries.store') }}" method="POST">
                @csrf
                <h1>Création d'un pays</h1>
                <hr/>

                <div class="flex gap-4 mb-4">
                    <div class="w-8/12">
                        <x-Form.Label for="name" block required>Nom du pays</x-Form.Label>
                        <x-Form.Input name="name" placeholder="Nom du pays" value="{{ old('name') }}"/>
                    </div>
                    <div class="w-4/12">
                        <x-Form.Label for="code" block>Code ISO</x-Form.Label>
                        <x-Form.Input name="code" placeholder="FRA" value="{{ old('code') }}"/>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <x-Form.Btn type="submit">Ajouter le pays</x-Form.Btn>
                    <x-Form.Cancel href="{{ route('countries.index') }}"/>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
