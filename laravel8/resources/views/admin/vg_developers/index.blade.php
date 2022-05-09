<x-app-layout>
    <div id="dashboard_table">
        <x-admin.dashboard_menu menu="database" sub="vg_developers"/>
        
        <div class="right">
            <x-notification type="success" msg="{{ session('info') }}"/>

            <div class="relative flex justify-center border-b-2 mb-4">
                <span class="absolute left-0 font-semibold">{{ isset($vg_developers->links) ? $vg_developers->links()->paginator->total() : count($vg_developers) }} Resultats</span>
                <h1>Liste des développeurs de Jeux Vidéo</h1>
                <div class="absolute right-0">
                    <a title="Créer un développeur" href="{{ route('vg_developers.create') }}" class="title-icon inline-flex">
                        <x-svg.plus class="icon-xs"/>
                    </a>
                </div>
            </div>

            <div class="listing flex flex-col gap-4">
                @foreach($vg_developers as $vg_developer)
                    <div class="item_list flex flex-between gap-4 p-2 shadow rounded border-l-4 border-indigo-400 hover:shadow-lg transform hover:scale-105">
                        <div class="flex w-full items-center gap-8">
                            <span class="font-bold"># {{ $vg_developer->id }}</span>
                            <x-utils.v_line />
                            <span>{{ $vg_developer->label }}</span>
                            <x-utils.v_line />
                            <span>{{ $vg_developer->description(70) }}</span>
                            <x-utils.v_line />
                            <span>Créé en {{ $vg_developer->year_created }}</span>
                        </div>
                        <div class="flex flex-around gap-4 text-sm">
                            <a class="bg-indigo-600 text-gray-200 rounded p-1 px-4 hover:bg-indigo-400 hover:text-white" href="{{ route('vg_developers.edit', $vg_developer->id) }}">Editer</a>
                            <form action="{{ route('vg_developers.destroy', $vg_developer->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="bg-red-700 text-gray-200 rounded p-1 px-4 hover:bg-red-500 hover:text-white" type="submit">Supprimer</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
