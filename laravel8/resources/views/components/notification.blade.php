@if(session()->has('info') || isset($example))
    <div class="notification is-{{ $type }}">
        <div>
            @if($type === 'success')
                <x-svg.check class="icon-sm mr-1"/>
            @elseif($type === 'error')
                <x-svg.close class="icon-sm mr-1"/>
            @endif
            {{ $msg }}
        </div>
    </div>
@endif