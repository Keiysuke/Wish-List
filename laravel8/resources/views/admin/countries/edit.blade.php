<x-app-layout>
    <div id="dashboard-table">
        <x-admin.dashboard_menu menu="database" sub="countries"/>

        <div class="right">
            <x-Notification type="success" msg="{{ session('info') }}"/>

            <form class="bg-white rounded px-8 pt-2 pb-8 mb-4" action="{{ route('countries.update', $country->id) }}" method="POST">
                @csrf
                @method('put')
                <div class="relative flex border-b-2 mb-4">
                    <h1>Edition du pays</h1>
                    <div class="absolute right-0">
                        <a title="Créer un pays" href="{{ route('countries.create') }}" class="title-icon inline-flex">
                            <x-svg.plus class="icon-xs"/>
                        </a>
                    </div>
                </div>

                <div class="flex gap-4 mb-4 items-center">
                    <div class="w-8/12">
                        <x-Form.Label for="name" block required>Nom du pays</x-Form.Label>
                        <x-Form.Input name="name" placeholder="Nom du pays" value="{{ old('name', $country->name) }}"/>
                    </div>
                    <div class="w-4/12">
                        <x-Form.Label for="code" block>Code ISO</x-Form.Label>
                        <x-Form.Input name="code" placeholder="FRA" value="{{ old('code', $country->code) }}"/>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <x-Form.Btn type="submit">Modifier le pays</x-Form.Btn>
                    <x-Form.Cancel href="{{ route('countries.index') }}"/>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
