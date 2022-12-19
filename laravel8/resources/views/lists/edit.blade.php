@extends('template')

@section('breadcrumbs')
    {{ Breadcrumbs::render('edit', 'list', $list) }}
@endsection

@section('content')
<x-notification type="success" msg="{{ session('info') }}"/>

<div class="min-w-full max-w-xs">
    <form class="bg-white rounded px-8 pt-6 pb-8 mb-4" action="{{ route('lists.update', $list) }}" method="POST">
        @csrf
        @method('put')
        <h1>Edition d'une liste</h1>
        <hr/>

        <div class="flex gap-4">
            <div class="w-8/12">
                <x-form.label for="label" block required>Nom de la liste</x-form.label>
                <x-form.input name="label" placeholder="Liste d'envies" value="{{ old('label', $list->label) }}"/>
            </div>
            <div class="w-2/2">
                <x-form.label for="listing_type_id" block required>Type de liste</x-form.label>
                <select name="listing_type_id" id="listing_type_id" class="pl-2 h-10 block w-full rounded-md bg-gray-100 border-transparent">
                    @foreach($listing_types as $listing_type)
                        <option value="{{ $listing_type->id }}" @if(old('listing_type_id', $list->listing_type_id) == $listing_type->id) selected @endif>{{ $listing_type->label }}</option>
                    @endforeach
                </select>
                @error('listing_type_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="w-2/12 flex justify-center">
                <div class="pt-9">
                    <x-form.checkbox name="secret">{{ old('secret', $list->secret)? 'checked' : '' }}</x-form.checkbox>
                    <x-form.label class="ml-1" for="secret">Garder la surprise ?</x-form.label>
                </div>
            </div>
        </div>
        <div class="my-4">
            <x-form.label for="description" block>Description</x-form.label>
            <x-form.textarea name="description">{{ old('description', $list->description) }}</x-form.textarea>
        </div>

        <div class="flex items-center justify-between">
            <x-form.btn type="submit">Modifier la liste</x-form.btn>
            <x-form.cancel href="{{ route('lists.index') }}"/>
        </div>
    </form>
    </div>
@endsection