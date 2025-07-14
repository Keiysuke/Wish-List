<x-app-layout>
    <div id="dashboard-table">
        <x-admin.dashboard_menu menu="database" sub="book_publishers"/>
        
        <div class="right">
            <x-Notification type="success" msg="{{ session('info') }}"/>

            <div class="relative flex justify-center border-b-2 mb-4">
                <span class="absolute left-0 font-semibold">{{ isset($publishers->links) ? $publishers->links()->paginator->total() : count($publishers) }} Resultats</span>
                <h1>Liste des maisons d'édition</h1>
                <div class="absolute right-0">
                    <a title="Créer un support" href="{{ route('book_publishers.create') }}" class="title-icon inline-flex">
                        <x-svg.plus class="icon-xs"/>
                    </a>
                </div>
            </div>

            <div class="listing flex flex-col gap-4">
                @foreach($publishers as $publisher)
                    <div class="item_list flex flex-between gap-4 p-2 shadow rounded border-l-4 border-indigo-400 hover:shadow-lg transform hover:scale-105">
                        <div class="flex w-full items-center gap-8">
                            <span class="font-bold text-{{ $publisher->active ? 'green' : 'red' }}-400"># {{ $publisher->id }}</span>
                            <x-Utils.VLine />
                            <span class="inline-flex gap-2">
                                @if($publisher->type_id == \App\Models\PublisherType::BOOK)
                                    <x-svg.book class="icon-xs text-warm_gray-500"/>
                                @elseif($publisher->type_id == \App\Models\PublisherType::ANIME)
                                    <x-svg.film class="icon-xs"/>
                                @elseif($publisher->type_id == \App\Models\PublisherType::BOARDGAME)
                                    <x-svg.puzzle class="icon-xs text-yellow-500"/>
                                @endif
                                {!! $publisher->website->asLink() !!}
                            </span>
                            <x-Utils.VLine />
                            <span>{{ $publisher->city->name }}</span>
                            <x-Utils.VLine />
                            <span>Fondée en {{ $publisher->founded_year }}</span>
                        </div>
                        <div class="flex flex-around gap-4 text-sm">
                            <a class="bg-indigo-600 text-gray-200 rounded p-1 px-4 hover:bg-indigo-400 hover:text-white" href="{{ route('book_publishers.edit', $publisher->id) }}">Editer</a>
                            <form action="{{ route('book_publishers.destroy', $publisher->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="bg-red-700 text-gray-200 rounded p-1 px-4 hover:bg-red-500 hover:text-white" type="submit">Supprimer</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
            @if(count($publishers) > 0)
            <footer id="paginate" class="card-footer flex justify-center p-4">
                {{ $publishers->links() }}
            </footer>
            @endif
        </div>
    </div>
</x-app-layout>
