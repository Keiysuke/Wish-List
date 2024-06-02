<input 
    type="checkbox" 
    {{ (isset($check) && 'tag_'.$check == $name) ? 'checked' : '' }} 
    class="{{ $class ?? '' }}" 
    {{ $attributes }} 
    name="{{ $name }}" 
    id="{{ $id ?? str_replace('_', '-', $name) }}" 
    {{ $slot }}
    >