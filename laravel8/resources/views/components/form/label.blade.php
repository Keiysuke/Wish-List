<label 
    class="{{ $class?? '' }} {{ isset($block)? 'block ' : '' }}text-gray-600 text-sm font-semibold mb-2 {{ isset($create)? 'flex inline-flex' : '' }}" 
    {{ $attributes }}
    >
    @if(isset($create))
        <a href="{{ $create }}" target="_blank">
            <x-svg.circle_plus class="icon-xs mr-1 icon-clickable text-blue-600"/>
        </a>
    @endif
    {{ $slot }}
    @if(isset($showNbChars))
        @php($tmpId = \App\Http\Controllers\UtilsController::asId($showNbChars))
        <span id="show-nb-chars-{{ $tmpId }}" class="show-nb-chars" data-nb-chars="{{ $tmpId }}"></span>
    @endif
    @if(isset($required))
        <span class="required">
            *
        </span>
    @endif
</label>