<label class="{{ $class?? '' }} {{ isset($block)? 'block ' : '' }}text-gray-600 text-sm font-semibold mb-2" {{ $attributes }}>{{ $slot }}
    @if(isset($required)) <span class="required">*</span>
    @endif
</label>