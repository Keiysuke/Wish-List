<x-app-layout>
    <div id="dashboard-table">
        <x-admin.dashboard_menu menu="database" sub="product_states"/>

        <div class="right">
            <x-Notification type="success" msg="{{ session('info') }}"/>
            <form class="bg-white rounded px-8 pt-6 pb-8 mb-4" action="{{ route('states.products.update', $productState) }}" method="POST">
                @csrf
                @method('put')
                <h1>Edition d'un état de produit</h1>
                <hr/>
                
                <div class="mb-4">
                    <x-Form.Label for="label" block required>Nom de l'état</x-Form.Label>
                    <x-Form.Input name="label" placeholder="Neuf" value="{{ old('label', $productState->label) }}"/>
                </div>
                <div class="flex items-center justify-between">
                    <x-Form.Btn type="submit">Modifier l'état</x-Form.Btn>
                    <x-Form.Cancel href="{{ route('states.products.index') }}"/>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
