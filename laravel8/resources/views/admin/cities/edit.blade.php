<x-app-layout>
    <div id="dashboard-table">
        <x-admin.dashboard_menu menu="database" sub="cities"/>

        <div class="right">
            <x-Notification type="success" msg="{{ session('info') }}"/>

            <form class="bg-white rounded px-8 pt-2 pb-8 mb-4" action="{{ route('cities.update', $city->id) }}" method="POST">
                @csrf
                @method('put')
                <div class="relative flex border-b-2 mb-4">
                    <h1>Edition de la ville</h1>
                    <div class="absolute right-0">
                        <a title="Créer une ville" href="{{ route('cities.create') }}" class="title-icon inline-flex">
                            <x-svg.plus class="icon-xs"/>
                        </a>
                    </div>
                </div>

                <div class="flex gap-4 mb-4 items-center">
                    <div class="w-3/12">
                        <x-Form.Label for="country_id" block required create="{{ route('countries.create') }}">Pays</x-Form.Label>
                        <select name="country_id" class="form-select pl-2 h-10 block w-full rounded-md bg-gray-100 border-transparent">
                            @foreach($countries as $country)
                                <option value="{{ $country->id }}" {{ old('country_id', $city->country_id) == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-6/12">
                        <x-Form.Label for="name" block required>Nom de la ville</x-Form.Label>
                        <x-Form.Input name="name" placeholder="Nom de la ville" value="{{ old('name', $city->name) }}"/>
                    </div>
                    <div class="w-3/12">
                        <x-Form.Label for="postal_code" block>Code postal</x-Form.Label>
                        <x-Form.Input name="postal_code" placeholder="Code postal" value="{{ old('postal_code', $city->postal_code) }}"/>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <x-Form.Btn type="submit">Modifier la ville</x-Form.Btn>
                    <x-Form.Cancel href="{{ route('cities.index') }}"/>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
