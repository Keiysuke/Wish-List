<div class="inline-flex">
    <x-Form.Radio id="{{ $id ?? str_replace('_', '-', $value) }}" name="{{ $name }}" value="{{ $value }}">{{ (isset($checked) && ($checked == 1 || $checked === $value)) ? 'checked' : '' }}</x-Form.Radio>
    <x-Form.Label class="text-gray-600 text-sm font-semibold mb-2" for="{{ $id ?? str_replace('_', '-', $value) }}">{{ $slot }}</x-Form.Label>
</div>