<x-app-layout>
    <div id="dashboard_table">
        <x-admin.dashboard_menu menu="database" sub="product_states"/>

        <div class="right">
            <x-notification type="success" msg="{{ session('info') }}"/>
            <form class="bg-white rounded px-8 pt-6 pb-8 mb-4" action="{{ route('states.products.update', $product_state) }}" method="POST">
                @csrf
                @method('put')
                <h1>Edition d'un état de produit</h1>
                <hr/>
                
                <div class="mb-4">
                    <label class="block text-gray-600 text-sm font-semibold mb-2" for="label">Nom de l'état <span class="required">*</span></label>
                    <input class="bg-gray-100 appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="label" id="label" type="text" placeholder="Neuf" value="{{ old('label', $product_state->label) }}"/>
                    @error('label')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="flex items-center justify-between">
                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                        Modifier l'état
                    </button>
                    <a class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800" href="{{ route('states.products.index') }}">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
