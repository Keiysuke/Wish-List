<x-app-layout>
    <div id="dashboard_table">
        <x-admin.dashboard_menu menu="database" sub="sell_states"/>
        
        <div class="right">
            <x-notification type="success" msg="{{ session('info') }}"/>

            <div class="relative flex justify-center border-b-2 mb-4">
                <span class="absolute left-0 font-semibold">{{ isset($sell_states->links) ? $sell_states->links()->paginator->total() : count($sell_states) }} Resultats</span>
                <h1>Liste des états de vente</h1>
                <div class="absolute right-0">
                    <a title="Créer un état de vente" href="{{ route('states.sells.create') }}" class="title-icon inline-flex">
                        <x-svg.plus class="icon-xs"/>
                    </a>
                </div>
            </div>

            <div class="listing flex flex-col gap-4">
                @foreach($sell_states as $sell_state)
                    <div class="item_list flex flex-between gap-4 p-2 shadow rounded border-l-4 border-indigo-400 hover:shadow-lg transform hover:scale-105">
                        <div class="flex w-full gap-8">
                            <span class="font-bold"># {{ $sell_state->id }}</span>
                            <span class="vertical-line"></span>
                            <span>{{ $sell_state->label }}</span>
                        </div>
                        <div class="flex flex-around gap-4 text-sm">
                            <a class="bg-indigo-600 text-gray-200 rounded p-1 px-4 hover:bg-indigo-400 hover:text-white" href="{{ route('states.sells.edit', $sell_state->id) }}">Editer</a>
                            <form action="{{ route('states.sells.destroy', $sell_state->id) }}" method="post">
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
