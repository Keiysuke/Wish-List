<x-app-layout>
    <div id="dashboard_table">
        <x-admin.dashboard_menu menu="database" sub="emojis"/>

        <div class="right">
            <x-notification type="success" msg="{{ session('info') }}"/>
            
            <form class="bg-white rounded px-8 pt-6 pb-8 mb-4" action="{{ route('emojis.store') }}" method="POST">
                @csrf
                <h1>Création d'un Emoji</h1>
                <hr/>

                <div class="flex gap-4 mb-4">
                    <div class="w-2/3">
                        <x-form.label for="emoji_section_id" block required create="{{ route('sections.emojis.create') }}">Section d'émojis</x-form.label>
                        <select name="emoji_section_id" id="emoji_section_id" class="pl-2 h-10 block w-full rounded-md bg-gray-100 border-transparent">
                            @foreach($sections as $section)
                                <option value="{{ $section->id }}" @if(old('emoji_section_id') == $section->id) selected @endif>{{ $section->label }}</option>
                            @endforeach
                        </select>
                        @error('emoji_section_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="w-1/3">
                        <x-form.label for="label" block required>Emoji</x-form.label>
                        <x-form.input name="label" value="{{ old('label') }}"/>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center block gap-4">
                        <x-form.btn type="submit">Ajouter l'émoji</x-form.btn>
                    </div>
                    <x-form.cancel href="{{ route('emojis.index') }}"/>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
