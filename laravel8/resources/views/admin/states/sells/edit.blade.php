<x-app-layout>
    <div id="dashboard_table">
        <x-admin.dashboard_menu menu="database" sub="sell_states"/>

        <div class="right">
            <x-notification type="success" msg="{{ session('info') }}"/>
            
            <form class="bg-white rounded px-8 pt-6 pb-8 mb-4" action="{{ route('states.sells.update', $sell_state) }}" method="POST">
                @csrf
                @method('put')
                <h1>Edition d'un état de vente</h1>
                <hr/>
                
                <div class="mb-4">
                    <x-form.label for="label" block required>Nom de l'état</x-form.label>
                    <x-form.input name="label" placeholder="Neuf" value="{{ old('label', $sell_state->label) }}"/>
                </div>
                <div class="flex items-center justify-between">
                    <x-form.btn type="submit">Modifier l'état</x-form.btn>
                    <x-form.cancel href="{{ route('states.sells.index') }}"/>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
