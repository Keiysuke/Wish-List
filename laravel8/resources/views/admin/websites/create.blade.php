<x-app-layout>
    <div id="dashboard_table">
        <x-admin.dashboard_menu menu="database" sub="websites"/>

        <div class="right">
            <x-notification type="success" msg="{{ session('info') }}"/>
            
            <form class="bg-white rounded px-8 pt-6 pb-8 mb-4" action="{{ route('websites.store') }}" method="POST">
                @csrf
                <h1>Création d'un site</h1>
                <hr/>

                <div class="mb-4">
                    <label class="block text-gray-600 text-sm font-semibold mb-2" for="label">Nom du site <span class="required">*</span></label>
                    <input class="bg-gray-100 appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="label" id="label" type="text" placeholder="Nom du site" value="{{ old('label') }}"/>
                    @error('label')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-gray-600 text-sm font-semibold mb-2" for="url">Url <span class="required">*</span></label>
                    <input class="bg-gray-100 appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="url" id="url" type="text" placeholder="Url" value="{{ old('url') }}"/>
                    @error('url')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="flex items-center justify-between">
                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                        Ajouter le site
                    </button>
                    <a class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800" href="{{ route('websites.index') }}">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
