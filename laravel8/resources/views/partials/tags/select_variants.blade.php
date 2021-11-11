@if(count($variants) === 1 && empty($variants[0]))
    <option value="">Aucune</option>
@else
    @foreach($variants as $variant)
        <option value="{{ $variant }}" @if(isset($selected) && $selected === $variant) selected @endif>{{ $variant }}</option>
    @endforeach
@endif