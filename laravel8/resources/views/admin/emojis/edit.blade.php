<x-app-layout>
    <div id="dashboard-table">
        <x-admin.dashboard_menu menu="database" sub="emojis"/>

        <div class="right">
            <x-Notification type="success" msg="{{ session('info') }}"/>

            <form class="bg-white rounded px-8 pt-2 pb-8 mb-4" action="{{ route('emojis.update', $emoji->id) }}" method="POST">
                @csrf
                @method('put')
                <h1>Edition d'émoji</h1>
                <hr/>

                <div class="flex gap-4 mb-4">
                    <div class="w-2/3">
                        <x-Form.Label for="emoji-section-id" block required create="{{ route('sections.emojis.create') }}">Section d'émojis</x-Form.Label>
                        <select name="emoji_section_id" id="emoji-section-id" class="pl-2 h-10 block w-full rounded-md bg-gray-100 border-transparent">
                            @foreach($sections as $section)
                                <option value="{{ $section->id }}" @if(old('emoji_section_id', $emoji->section->id) == $section->id) selected @endif>{{ $section->label }}</option>
                            @endforeach
                        </select>
                        @error('emoji_section_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="w-2/3">
                        <x-Form.Label for="label" block required>Emoji</x-Form.Label>
                        <x-Form.Input name="label" value="{{ old('label', $emoji->label) }}"/>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <x-Form.Btn type="submit">Modifier l'émoji</x-Form.Btn>
                    <x-Form.Cancel href="{{ route('emojis.index') }}"/>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
