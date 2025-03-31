<x-app-layout>
    <div id="dashboard-table">
        <x-admin.dashboard_menu menu="database" sub="tags"/>

        <div class="right">
            <x-Notification type="success" msg="{{ session('info') }}"/>

            <form class="flex flex-col gap-4 bg-white rounded px-8 pt-2" action="{{ route('tags.update', $tag->id) }}" method="POST">
                @csrf
                @method('put')
                <div class="relative flex border-b-2 mb-4">
                    <h1>Edition du tag</h1>
                    <div class="absolute right-0">
                        <a title="Créer un site" href="{{ route('tags.create') }}" class="title-icon inline-flex">
                            <x-svg.plus class="icon-xs"/>
                        </a>
                    </div>
                </div>

                <div class="flex mb-4">
                    <div class="w-1/2">
                        <x-Form.Label for="label" block required>Nom du tag</x-Form.Label>
                        <x-Form.Input name="label" placeholder="Nom du tag" value="{{ old('label', $tag->label) }}"/>
                    </div>
                    <div class="flex w-1/2 justify-center items-end pb-2 gap-4">
                        <div><x-Tags.Tag :tag="$tag" /></div>
                        <div id="content-ex-tag"></div>
                    </div>
                </div>
                <div class="flex gap-12 mb-4">
                    <div class="w-1/3">
                        @include('partials.tags.edit_colors', ['tag' => $tag, 'kind_css_color' => 'border'])
                    </div>
                    <div class="w-1/3">
                        @include('partials.tags.edit_colors', ['tag' => $tag, 'kind_css_color' => 'text'])
                    </div>
                    <div class="w-1/3">
                        @include('partials.tags.edit_colors', ['tag' => $tag, 'kind_css_color' => 'bg'])
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <x-Form.Btn type="submit">Modifier le tag</x-Form.Btn>
                    <x-Form.Cancel href="{{ route('tags.index') }}"/>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
