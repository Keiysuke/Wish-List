<x-app-layout>
    <div id="dashboard-table">
        <x-admin.dashboard_menu menu="database" sub="cities"/>

        <div class="right">
            <x-Notification type="success" msg="{{ session('info') }}"/>

            <form class="bg-white rounded px-8 pt-6 pb-8 mb-4" action="{{ route('cities.store') }}" method="POST">
                @csrf
                <h1>Création d'une ville</h1>
                <hr/>

                <div class="flex gap-4 mb-4 items-center">
                    <div class="w-3/12">
                        <x-Form.Label for="country_id" block required create="{{ route('countries.create') }}">Pays</x-Form.Label>
                        <select name="country_id" class="form-select pl-2 h-10 block w-full rounded-md bg-gray-100 border-transparent">
                            @foreach($countries as $country)
                                <option value="{{ $country->id }}" {{ old('country_id') == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
                            @endforeach
                        </select>
                        @error('country_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="w-6/12">
                        <x-Form.Label for="name" block required>Nom de la ville</x-Form.Label>
                        <x-Form.Input name="name" placeholder="Nom de la ville" value="{{ old('name') }}"/>
                    </div>
                    <div class="w-3/12">
                        <x-Form.Label for="postal_code" block>Code postal</x-Form.Label>
                        <x-Form.Input name="postal_code" placeholder="Code postal" value="{{ old('postal_code') }}"/>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <x-Form.Btn type="submit">Ajouter la ville</x-Form.Btn>
                    <x-Form.Cancel href="{{ route('cities.index') }}"/>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
