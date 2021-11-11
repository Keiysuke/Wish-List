<div class="inline-flex">
    <x-form.radio id="{{ $id ?? $value }}" name="{{ $name }}" value="{{ $value }}">{{ isset($checked)? 'checked' : '' }}</x-form.radio>
    <x-form.label class="text-gray-600 text-sm font-semibold mb-2" for="{{ $id ?? $value }}">{{ $slot }}</x-form.label>
</div>