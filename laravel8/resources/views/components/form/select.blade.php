<select class="{{ $class ?? '' }}" id="{{ $id ?? $name }}">
    {{ isset($slot) ? $slot : '' }}
    @foreach($datas as $data)
        <option value="{{ $data->id }}">{{ $data->label }}</option>
    @endforeach
</select>
@if(isset($message))
    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
@endif