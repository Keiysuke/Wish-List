<x-app-layout>
    <div id="dashboard_table">
        <x-admin.dashboard_menu menu="database" sub="tags"/>

        <div class="right">
            <x-notification type="success" msg="{{ session('info') }}"/>

            <form class="flex flex-col gap-4 bg-white rounded px-8 pt-2" action="{{ route('tags.update', $tag->id) }}" method="POST">
                @csrf
                @method('put')
                <h1>Edition du tag</h1>
                <hr/>

                <div class="flex mb-4">
                    <div class="w-1/2">
                        <x-form.label for="label" block required>Nom du tag</x-form.label>
                        <x-form.input name="label" placeholder="Nom du tag" value="{{ old('label', $tag->label) }}"/>
                    </div>
                    <div class="flex w-1/2 justify-center items-end pb-2 gap-4">
                        <div><x-tags.tag :tag="$tag" /></div>
                        <div id="content_ex_tag"></div>
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
                    <x-form.btn type="submit">Modifier le tag</x-form.btn>
                    <x-form.cancel href="{{ route('tags.index') }}"/>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
