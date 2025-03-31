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
@if ($errors->any())
    <div class="notification is-error">
        <div>
            <x-svg.close class="icon-sm mr-1"/>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif