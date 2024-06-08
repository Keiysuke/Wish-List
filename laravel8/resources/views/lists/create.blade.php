@extends('template')

@section('breadcrumbs')
    {{ Breadcrumbs::render('create', 'list') }}
@endsection

@section('content')
<x-Notification type="success" msg="{{ session('info') }}"/>

<div class="min-w-full max-w-xs">
    <form class="bg-white rounded px-8 pt-6 pb-8 mb-4" action="{{ route('lists.store') }}" method="POST">
        @csrf
        <h1>Création d'une liste</h1>
        <hr/>

        <input type="hidden" value="{{ auth()->user()->id }}" name="user_id" id="user-id"/>
        <div class="flex gap-4">
            <div class="w-8/12">
                <x-Form.Label for="label" block required>Nom de la liste</x-Form.Label>
                <x-Form.Input name="label" placeholder="Liste d'envies" value="{{ old('label') }}"/>
            </div>
            <div class="w-2/2">
                <x-Form.Label for="listing-type-id" block required>Type de liste</x-Form.Label>
                <select name="listing_type_id" id="listing-type-id" class="pl-2 h-10 block w-full rounded-md bg-gray-100 border-transparent">
                    @foreach($listingTypes as $listingType)
                        <option value="{{ $listingType->id }}" @if(old('listing_type_id', 1) == $listingType->id) selected @endif>{{ $listingType->label }}</option>
                    @endforeach
                </select>
                @error('listing_type_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="w-2/12 flex justify-center">
                <div class="pt-9">
                    <x-Form.Checkbox name="secret">{{ old('secret')? 'checked' : '' }}</x-Form.Checkbox>
                    <x-Form.Label class="ml-1" for="secret">Garder la surprise ?</x-Form.Label>
                </div>
            </div>
        </div>
        <div class="my-4">
            <x-Form.Label for="description" block>Description</x-Form.Label>
            <x-Form.Textarea name="description">{{ old('description') }}</x-Form.Textarea>
        </div>

        <div class="flex items-center justify-between">
            <x-Form.Btn type="submit">Créer la liste</x-Form.Btn>
            <x-Form.Cancel href="{{ route('lists.index') }}"/>
        </div>
    </form>
    </div>
@endsection