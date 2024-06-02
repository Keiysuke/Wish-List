<input 
    type="radio" 
    class="mr-2 mt-1" 
    name="{{ $name }}" 
    id="{{ $id ?? str_replace('_', '-', $value) }}" 
    value="{{ $value }}" 
    {{ $slot }}
    />