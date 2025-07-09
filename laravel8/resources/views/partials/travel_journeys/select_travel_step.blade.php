<div id="travel-step-{{ $nb }}">
    <input type="hidden" value="{{ isset($step) ? $step->id : 0 }}" name="travel_step_id_{{ $nb }}" id="travel-step-id-{{ $nb }}"/>

    <h3 id="travel-step-name-{{ $nb }}" class="font-bold underline">{{ ($nb + 1) }} - Arrêt à {{ $step->city->name ?? $cities->first()->name }}</h3>
    <div class="flex gap-4 p-4 items-center">
        <div class="flex flex-col gap-1 justify-center items-center inline left-0">
            <x-Form.Checkbox name="travel_step_delete_{{ $nb }}"></x-Form.Checkbox>
            <x-Form.Label for="travel-step-delete-{{ $nb }}">
                <x-svg.trash class="icon-xs"/>
            </x-Form.Label>
        </div>
        <div class="w-6/12">
            <x-Form.Label class="relative" for="travel-step-city-id-{{ $nb }}" block required create="{{ route('cities.create') }}">
                Ville
            </x-Form.Label>
            <select name="travel_step_city_id_{{ $nb }}" id="travel-step-city-id-{{ $nb }}" data-nb="{{ $nb }}" class="travel-step-city dynamic-selected-travel-step pl-2 h-10 block w-full rounded-md bg-gray-100 border-transparent">
                @foreach($cities as $city)
                    <option id="travel-step-city-id-{{ $nb }}_{{ $city->id }}" value="{{ $city->id }}" @if(old('travel_step_city_id_'.$nb, ($step->city_id ?? null)) == $city->id) selected @endif>{{ $city->name }}</option>
                @endforeach
            </select>
            @error('travel_step_city_id_'.$nb)
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="w-3/12" id="travel-step-start-date-{{ $nb }}">
            <x-Form.Label for="travel-step-start-date-val-{{ $nb }}" block>Date d'arrivée</x-Form.Label>
            <x-Form.Date class="dynamic-value-travel-step" id="travel_step_start_date_val_{{ $nb }}" name="travel_step_start_date_{{ $nb }}" value="{{ old('travel_step_start_date_'.$nb, ($step->start_date ?? null)) }}"/>
        </div>
        <div class="w-3/12" id="travel-step-end-date-{{ $nb }}">
            <x-Form.Label for="travel-step-end-date-val-{{ $nb }}" block>Date de départ</x-Form.Label>
            <x-Form.Date class="dynamic-value-travel-step" id="travel_step_end_date_val_{{ $nb }}" name="travel_step_end_date_{{ $nb }}" value="{{ old('travel_step_end_date_'.$nb, ($step->end_date ?? null)) }}"/>
        </div>
    </div>
</div>
<hr class="border-emerald-500"/>