<x-app-layout>
    <div id="dashboard-table">
        <x-admin.dashboard_menu menu="database" sub="book_publishers"/>

        <div class="right">
            <x-Notification type="success" msg="{{ session('info') }}"/>
            
            <form class="bg-white rounded px-8 pt-6 pb-8 mb-4" action="{{ route('book_publishers.update', $publisher) }}" method="POST">
                @csrf
                @method('put')
                <div class="relative flex border-b-2 mb-4">
                    <h1>Edition d'une maison d'édition</h1>
                    <div class="absolute right-0">
                        <a title="Créer un support" href="{{ route('book_publishers.create') }}" class="title-icon inline-flex">
                            <x-svg.plus class="icon-xs"/>
                        </a>
                    </div>
                </div>
                
                <div class="w-full flex inline-flex justify-between mb-4 gap-4">
                    <div class="w-1/6">
                        <x-Form.Label for="type_id" block required>Type de maison d'édition</x-Form.Label>
                        <select name="type_id" class="form-select pl-2 h-10 block w-full rounded-md bg-gray-100 border-transparent">
                            @foreach($publisherTypes as $publisherType)
                                <option value="{{ $publisherType->id }}" {{ old('type_id', $publisher->type_id) == $publisherType->id ? 'selected' : '' }}>{{ $publisherType->getName() }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-2/6">
                        <x-Form.Label for="label" block required>Nom de la maison d'édition</x-Form.Label>
                        <x-Form.Input name="label" placeholder="Third Editions" value="{{ old('label', $publisher->label) }}"/>
                    </div>
                    <div class="w-1/6">
                        <x-Form.Label for="founded-year" block>Année de fondation</x-Form.Label>
                        <x-Form.Input name="founded_year" value="{{ old('founded_year', $publisher->founded_year) }}"/>
                    </div>
                    <div class="w-1/6">
                        <x-Form.Label for="city_id" block required create="{{ route('cities.create') }}">Pays</x-Form.Label>
                        <select name="city_id" class="form-select pl-2 h-10 block w-full rounded-md bg-gray-100 border-transparent">
                            @foreach($cities as $city)
                                <option value="{{ $city->id }}" {{ old('city_id', $publisher->city->id) == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-1/6 flex inline-flex items-center pt-6">
                        <x-Form.Checkbox class="mr-1" name="active">{{ old('active', $publisher->active)? 'checked' : '' }}</x-Form.Checkbox>
                        <x-Form.Label class="ml-1" for="active" block>Active ?</x-Form.Label>
                    </div>
                </div>
                <div class="my-4">
                    <x-Form.Label for="description" block>Description</x-Form.Label>
                    <x-Form.Textarea name="description">{{ old('description', $publisher->description) }}</x-Form.Textarea>
                </div>

                <div class="flex items-center justify-between">
                    <x-Form.Btn type="submit">Modifier la maison d'édition</x-Form.Btn>
                    <x-Form.Cancel href="{{ route('book_publishers.index') }}"/>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
