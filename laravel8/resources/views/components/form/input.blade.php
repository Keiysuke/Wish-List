<input type="text" class="{{ $class ?? '' }} bg-gray-100 appearance-none border rounded w-{{ $w ?? 'full' }} py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="{{ $id ?? $name }}" {{ $attributes }}/>
@error($name)
    <div class="invalid-feedback">{{ $message }}</div>
@enderror