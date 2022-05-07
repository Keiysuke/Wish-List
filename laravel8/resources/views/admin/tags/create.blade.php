<x-app-layout>
    <div id="dashboard_table">
        <x-admin.dashboard_menu menu="database" sub="tags"/>

        <div class="right">
            <x-notification type="success" msg="{{ session('info') }}"/>
            
            <form class="bg-white rounded px-8 pt-6 pb-8 mb-4" action="{{ route('tags.store') }}" method="POST">
                @csrf
                <h1>Création d'un tag</h1>
                <hr/>

                <div class="flex gap-4 mb-4">
                    <div class="w-2/3">
                        <x-form.label for="label" block required>Nom du tag</x-form.label>
                        <x-form.input name="label" placeholder="Nom du tag" value="{{ old('label') }}"/>
                    </div>
                    <div class="flex w-1/2 justify-center items-end pb-2 gap-4">
                        <div id="content_ex_tag"><x-tags.tag id="ex_tag" :tag="\App\Models\Tag::getExample()" /></div>
                    </div>
                </div>
                <div class="flex gap-12 mb-4">
                    <div class="w-1/3">
                        @include('partials.tags.edit_colors', ['kind_css_color' => 'border'])
                    </div>
                    <div class="w-1/3">
                        @include('partials.tags.edit_colors', ['kind_css_color' => 'text'])
                    </div>
                    <div class="w-1/3">
                        @include('partials.tags.edit_colors', ['kind_css_color' => 'bg'])
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center block gap-4">
                        <x-form.btn type="submit">Ajouter le tag</x-form.btn>
                    </div>
                    <x-form.cancel href="{{ route('tags.index') }}"/>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
