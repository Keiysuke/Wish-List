<textarea 
    rows="{{ $rows ?? 4 }}" 
    cols="{{ $cols ?? 50 }}" 
    class="bg-gray-100 p-1 appearance-none border rounded w-full text-gray-700 leading-tight focus:outline-none focus:shadow-outline {{ $class ?? '' }}" 
    name="{{ $name }}" 
    id="{{ $id ?? $name }}"/>{{ $slot }}</textarea>
@error($name)
    <div class="invalid-feedback">{{ $message }}</div>
@enderror