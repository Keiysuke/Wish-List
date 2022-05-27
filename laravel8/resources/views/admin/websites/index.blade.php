<x-app-layout>
    <div id="dashboard_table">
        <x-admin.dashboard_menu menu="database" sub="websites"/>
        
        <div class="right">
            <x-notification type="success" msg="{{ session('info') }}"/>

            <div class="relative flex justify-center border-b-2 mb-4">
                <span class="absolute left-0 font-semibold">{{ isset($websites->links) ? $websites->links()->paginator->total() : count($websites) }} Resultats</span>
                <h1>Liste des sites</h1>
                <div class="absolute right-0">
                    <a title="Créer un site" href="{{ route('websites.create') }}" class="title-icon inline-flex">
                        <x-svg.plus class="icon-xs"/>
                    </a>
                </div>
            </div>

            <div class="listing flex flex-col gap-4">
                @foreach($websites as $website)
                    <div class="item_list flex flex-between gap-4 p-2 shadow rounded border-l-4 border-indigo-400 hover:shadow-lg transform hover:scale-105">
                        <div class="flex w-full items-center gap-8">
                            <span class="font-bold"># {{ $website->id }}</span>
                            <x-utils.v_line />
                            <span class="inline-flex gap-2">{{ $website->label }}
                                @if($website->can_sell)
                                    <x-svg.truck class="icon-xs text-green-500"/>
                                @endif
                            </span>
                            <x-utils.v_line />
                            <span>{{ $website->url }}</span>
                        </div>
                        <div class="flex flex-around items-center gap-4 text-sm">
                            <a class="bg-indigo-600 text-gray-200 rounded p-1 px-4 hover:bg-indigo-400 hover:text-white" href="{{ route('websites.edit', $website->id) }}">Editer</a>
                            <form action="{{ route('websites.destroy', $website->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="bg-red-700 text-gray-200 rounded p-1 px-4 hover:bg-red-500 hover:text-white" type="submit">Supprimer</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
            @if(count($websites) > 0)
            <footer id="paginate" class="card-footer flex justify-center p-4">
                {{ $websites->links() }}
            </footer>
            @endif
        </div>
    </div>
</x-app-layout>
