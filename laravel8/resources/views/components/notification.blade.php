@if(session()->has('info'))
    <div class="notification is-{{ $type }}">
        <div>
            @if($type === 'success')
                <x-svg.check class="icon-sm mr-1"/>
            @endif
            {{ $msg }}
        </div>
    </div>
@endif