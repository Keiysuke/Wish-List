<div class="ml-10">
    @if(count($product_websites) == 0)
        Aucun site disponible
    @else
        <ul class="list-disc">
        @foreach ($product_websites as $pw)
            <li class="li_website {{ ($pw->expired)? 'expired hidden' : '' }}">
                <a class="link" href="{{ (is_null($pw->url))? $pw->website->url : $pw->url }}" target="_blank">{{ $pw->website->label }}</a> pour <span class="font-semibold {{ $pw->lower_price ? 'text-green-500' : 'text-red-500' }}">{{ $pw->price }}€</span>
                <span class="text-xs {{ $pw->available_soon ? 'text-orange-500' : 'text-gray-500' }}">{{ $pw->date_show }}</span>
                
                <a title="Editer les infos" href="{{ route('product_websites.edit', ['product_website' => $pw->id]) }}" class="icon-xs icon-clickable inline-flex text-gray-700 {{ ($pw->expired)? 'ml-2' : '' }}">
                    <svg class="w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" /></svg>
                </a>
            </li>
        @endforeach
        </ul>
    @endif
</div>