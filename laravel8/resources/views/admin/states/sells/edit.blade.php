<x-app-layout>
    <div id="dashboard-table">
        <x-admin.dashboard_menu menu="database" sub="sell_states"/>

        <div class="right">
            <x-Notification type="success" msg="{{ session('info') }}"/>
            
            <form class="bg-white rounded px-8 pt-6 pb-8 mb-4" action="{{ route('states.sells.update', $sellState) }}" method="POST">
                @csrf
                @method('put')
                <div class="relative flex border-b-2 mb-4">
                    <h1>Edition d'un état de vente</h1>
                    <div class="absolute right-0">
                        <a title="Créer un état de vente" href="{{ route('states.sells.create') }}" class="title-icon inline-flex">
                            <x-svg.plus class="icon-xs"/>
                        </a>
                    </div>
                </div>
                
                <div class="mb-4">
                    <x-Form.Label for="label" block required>Nom de l'état</x-Form.Label>
                    <x-Form.Input name="label" placeholder="Neuf" value="{{ old('label', $sellState->label) }}"/>
                </div>
                <div class="flex items-center justify-between">
                    <x-Form.Btn type="submit">Modifier l'état</x-Form.Btn>
                    <x-Form.Cancel href="{{ route('states.sells.index') }}"/>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
