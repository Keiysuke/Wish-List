<x-app-layout>
    <div id="dashboard_table">
        <x-admin.dashboard_menu menu="database" sub="vg_supports"/>
        
        <div class="right">
            <x-notification type="success" msg="{{ session('info') }}"/>

            <div class="relative flex justify-center border-b-2 mb-4">
                <span class="absolute left-0 font-semibold">{{ isset($vg_supports->links) ? $vg_supports->links()->paginator->total() : count($vg_supports) }} Resultats</span>
                <h1>Liste des supports de Jeux Vidéo</h1>
                <div class="absolute right-0">
                    <a title="Créer un support" href="{{ route('vg_supports.create') }}" class="title-icon inline-flex">
                        <x-svg.plus class="icon-xs"/>
                    </a>
                </div>
            </div>

            <div class="listing flex flex-col gap-4">
                @foreach($vg_supports as $vg_support)
                    <div class="item_list flex flex-between gap-4 p-2 shadow rounded border-l-4 border-indigo-400 hover:shadow-lg transform hover:scale-105">
                        <div class="flex w-full items-center gap-8">
                            <span class="font-bold"># {{ $vg_support->id }}</span>
                            <x-utils.v_line />
                            <span>{{ $vg_support->with_alias() }}</span>
                            <x-utils.v_line />
                            <span>{{ $vg_support->price }} €</span>
                            <x-utils.v_line />
                            <span>{{ $vg_support->date_released() }}</span>
                        </div>
                        <div class="flex flex-around gap-4 text-sm">
                            <a class="bg-indigo-600 text-gray-200 rounded p-1 px-4 hover:bg-indigo-400 hover:text-white" href="{{ route('vg_supports.edit', $vg_support->id) }}">Editer</a>
                            <form action="{{ route('vg_supports.destroy', $vg_support->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="bg-red-700 text-gray-200 rounded p-1 px-4 hover:bg-red-500 hover:text-white" type="submit">Supprimer</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
            @if(count($vg_supports) > 0)
            <footer id="paginate" class="card-footer flex justify-center p-4">
                {{ $vg_supports->links() }}
            </footer>
            @endif
        </div>
    </div>
</x-app-layout>
