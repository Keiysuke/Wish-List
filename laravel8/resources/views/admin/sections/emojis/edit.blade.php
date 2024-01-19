<x-app-layout>
    <div id="dashboard_table">
        <x-admin.dashboard_menu menu="database" sub="emoji_sections"/>

        <div class="right">
            <x-notification type="success" msg="{{ session('info') }}"/>
            
            <form class="bg-white rounded px-8 pt-6 pb-8 mb-4" action="{{ route('sections.emojis.update', $section) }}" method="POST">
                @csrf
                @method('put')
                <h1>Edition d'une section d'émojis</h1>
                <hr/>
                
                <div class="mb-4">
                    <x-form.label for="label" block required>Nom de la section</x-form.label>
                    <x-form.input name="label" placeholder="Visages souriants" value="{{ old('label', $section->label) }}"/>
                </div>
                <div class="flex items-center justify-between">
                    <x-form.btn type="submit">Modifier la section</x-form.btn>
                    <x-form.cancel href="{{ route('sections.emojis.index') }}"/>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
