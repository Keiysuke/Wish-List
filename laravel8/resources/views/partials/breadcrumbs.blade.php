@if (count($breadcrumbs))
    <ol class="breadcrumb mb-4">
        @foreach ($breadcrumbs as $breadcrumb)
            @if ($breadcrumb->url && !$loop->last)
                <li class="breadcrumb-item"><a href="{{ $breadcrumb->url }}">{{ $breadcrumb->title }}</a></li>
            @else
                <li class="breadcrumb-item active">{{ $breadcrumb->title }}</li>
            @endif
            
            @if (!empty($breadcrumb->title) && !$loop->last)
                <li><span class="mx-2">/</span></li>
            @endif
        @endforeach
    </ol>
@endif