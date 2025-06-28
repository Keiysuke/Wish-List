<x-app-layout>
    <div id="dashboard-table">
        <x-admin.dashboard_menu menu="database" sub="cities"/>
        <div class="right">
            <x-Notification type="success" msg="{{ session('info') }}"/>
            <div class="relative flex justify-center border-b-2 mb-4">
                <span class="absolute left-0 font-semibold">{{ isset($cities->links) ? $cities->links()->paginator->total() : count($cities) }} Résultats</span>
                <h1>Liste des villes</h1>
                <div class="absolute right-0">
                    <a title="Créer une ville" href="{{ route('cities.create') }}" class="title-icon inline-flex">
                        <x-svg.plus class="icon-xs"/>
                    </a>
                </div>
            </div>
            <div class="listing flex flex-col gap-4">
                @foreach($cities as $city)
                    <div class="item_list flex flex-between gap-4 p-2 shadow rounded border-l-4 border-indigo-400 hover:shadow-lg transform hover:scale-105">
                        <div class="flex w-full items-center gap-8">
                            <span class="font-bold"># {{ $city->id }}</span>
                            <x-Utils.VLine />
                            <span class="inline-flex gap-2">
                                {{ $city->name }}
                                <span class="text-gray-500">({{ $city->postal_code }})</span>
                            </span>
                            <x-Utils.VLine />
                            <span>{{ $city->country->name }}</span>
                        </div>
                        <div class="flex flex-around items-center gap-4 text-sm">
                            <a class="bg-indigo-600 text-gray-200 rounded p-1 px-4 hover:bg-indigo-400 hover:text-white" href="{{ route('cities.edit', $city->id) }}">Editer</a>
                            <form action="{{ route('cities.destroy', $city->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="bg-red-700 text-gray-200 rounded p-1 px-4 hover:bg-red-500 hover:text-white" type="submit">Supprimer</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
            @if(count($cities) > 0)
            <footer id="paginate" class="card-footer flex justify-center p-4">
                {{ $cities->links() }}
            </footer>
            @endif
        </div>
    </div>
</x-app-layout>
