<div class="ml-10">
    @if(count($productWebsites) == 0)
        Aucun site disponible
    @else
        <ul class="list-disc">
        @foreach ($productWebsites as $pw)
            <li class="li-website {{ ($pw->expired)? 'expired hidden' : '' }}">
                <a class="link" href="{{ (is_null($pw->url))? $pw->website->url : $pw->url }}" target="_blank">{{ $pw->website->label }}</a> pour <span class="font-semibold {{ $pw->lower_price ? 'text-green-500' : 'text-red-500' }}">{{ $pw->price }}€</span>
                <span class="text-xs {{ $pw->available_soon ? 'text-orange-500' : 'text-gray-500' }}">{{ $pw->date_show }}</span>
                
                <a title="Editer les infos" href="{{ route('productWebsites.edit', ['product_website' => $pw->id]) }}" class="inline-flex text-gray-700 {{ ($pw->expired)? 'ml-2' : '' }}">
                    <x-svg.edit class="icon-xs icon-clickable"/>
                </a>
            </li>
        @endforeach
        </ul>
    @endif
</div>