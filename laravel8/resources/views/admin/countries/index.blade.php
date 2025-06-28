<x-app-layout>
    <div id="dashboard-table">
        <x-admin.dashboard_menu menu="database" sub="countries"/>
        <div class="right">
            <x-Notification type="success" msg="{{ session('info') }}"/>
            <div class="relative flex justify-center border-b-2 mb-4">
                <span class="absolute left-0 font-semibold">{{ isset($countries->links) ? $countries->links()->paginator->total() : count($countries) }} Résultats</span>
                <h1>Liste des pays</h1>
                <div class="absolute right-0">
                    <a title="Créer un pays" href="{{ route('countries.create') }}" class="title-icon inline-flex">
                        <x-svg.plus class="icon-xs"/>
                    </a>
                </div>
            </div>
            <div class="listing flex flex-col gap-4">
                @foreach($countries as $country)
                    <div class="item_list flex flex-between gap-4 p-2 shadow rounded border-l-4 border-indigo-400 hover:shadow-lg transform hover:scale-105">
                        <div class="flex w-full items-center gap-8">
                            <span class="font-bold"># {{ $country->id }}</span>
                            <x-Utils.VLine />
                            <span class="inline-flex gap-2">
                                {{ $country->name }}
                                <span class="text-gray-500">({{ $country->code }})</span>
                            </span>
                        </div>
                        <div class="flex flex-around items-center gap-4 text-sm">
                            <a class="bg-indigo-600 text-gray-200 rounded p-1 px-4 hover:bg-indigo-400 hover:text-white" href="{{ route('countries.edit', $country->id) }}">Editer</a>
                            <form action="{{ route('countries.destroy', $country->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="bg-red-700 text-gray-200 rounded p-1 px-4 hover:bg-red-500 hover:text-white" type="submit">Supprimer</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
            @if(count($countries) > 0)
            <footer id="paginate" class="card-footer flex justify-center p-4">
                {{ $countries->links() }}
            </footer>
            @endif
        </div>
    </div>
</x-app-layout>
