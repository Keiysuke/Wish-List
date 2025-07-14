@php($nb = isset($nb) ? '_'.$nb : '')
<div class="flex gap-4 mb-4 items-center">
    <div class="w-2/5">
        <x-Form.Label for="label{{ $nb }}" block required>Nom du jeu vidéo</x-Form.Label>
        <x-Form.Input name="label{{ $nb }}" placeholder="Uncharted : Lost Legacy" value="{{ old('label'.$nb) }}"/>
    </div>
    <div class="w-2/5">
        <x-Form.Label for="developer-id{{ $nb }}" block required create="{{ route('vg_developers.create') }}">Studio de développement</x-Form.Label>
        <select name="developer_id{{ $nb }}" id="developer-id" class="pl-2 h-10 block w-full rounded-md bg-gray-100 border-transparent">
            <option value="to_create">A créer</option>
            @foreach($developers as $developer)
                <option value="{{ $developer->id }}" @if(old('developer_id') === $developer->id) selected @endif>{{ $developer->label }}</option>
            @endforeach
        </select>
        @error('developer_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    
    <div class="w-1/5">
        <x-Form.Label for="date-released{{ $nb }}" block required>Date de sortie</x-Form.Label>
        <x-Form.Date name="date_released{{ $nb }}" type="date_released" value="{{ old('date_released'.$nb, $today) }}"/>
    </div>
    <div class="w-1/5">
        <x-Form.Label for="nb-players{{ $nb }}" block required>Nombre de joueurs (max)</x-Form.Label>
        <x-Form.Input name="nb_players{{ $nb }}" placeholder="1" value="{{ old('nb_players'.$nb, 1) }}"/>
    </div>
</div>