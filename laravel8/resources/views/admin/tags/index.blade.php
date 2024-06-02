<x-app-layout>
    <div id="dashboard-table">
        <x-admin.dashboard_menu menu="database" sub="tags"/>
        
        <div class="right">
            <x-Notification type="success" msg="{{ session('info') }}"/>

            <div class="relative flex justify-center border-b-2 mb-4">
                <span class="absolute left-0 font-semibold">{{ isset($tags->links) ? $tags->links()->paginator->total() : count($tags) }} Resultats</span>
                <h1>Liste des tags</h1>
                <div class="absolute right-0">
                    <a title="Créer un site" href="{{ route('tags.create') }}" class="title-icon inline-flex">
                        <x-svg.plus class="icon-xs"/>
                    </a>
                </div>
            </div>

            <div class="listing flex flex-col gap-4">
                @foreach($tags as $tag)
                    <div class="item_list flex flex-between gap-4 p-2 shadow rounded border-l-4 border-indigo-400 hover:shadow-lg transform hover:scale-105">
                        <div class="flex w-full items-center gap-8">
                            <span class="font-bold"># {{ $tag->id }}</span>
                            <x-Utils.VLine />
                            <span>{{ $tag->label }}</span>
                            <x-Utils.VLine />
                            <x-Tags.Tag :tag="$tag"/>
                        </div>
                        <div class="flex flex-around items-center gap-4 text-sm">
                            <a class="bg-indigo-600 text-gray-200 rounded p-1 px-4 hover:bg-indigo-400 hover:text-white" href="{{ route('tags.edit', $tag->id) }}">Editer</a>
                            <form action="{{ route('tags.destroy', $tag->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="bg-red-700 text-gray-200 rounded p-1 px-4 hover:bg-red-500 hover:text-white" type="submit">Supprimer</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
            @if(count($tags) > 0)
            <footer id="paginate" class="card-footer flex justify-center p-4">
                {{ $tags->links() }}
            </footer>
            @endif
        </div>
    </div>
</x-app-layout>
