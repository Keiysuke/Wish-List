<div class="{{ $class }} h-full w-full" onClick="toggle_thumbnail({{ $cpt }})">
    @if(is_null($sell))
        <div class="flex items-center justify-center" style="height:200px;">
            <a title="Créer & lier une nouvelle vente" class="bg-green-500 text-white font-semibold p-2 hover:bg-green-400 no-propagate" href="{{ route('sellings.create', ['purchase' => $purchase_id]) }}">
                Associer une vente
            </a>
        </div>
    @else
        <div class="relative bg-green-500 font-semibold uppercase rounded rounded-b-none text-white p-2">
            <div class="absolute left-2 top-2">
                <x-svg.truck class="w-5 h-5"/>
            </div>
            {{ $sell->sellState->label }}
            <div class="absolute right-2 top-2">
                <a title="Editer la vente" href="{{ route('sellings.edit', $sell->id) }}" class="no-propagate inline-flex items-center text-sm font-medium text-white hover:text-black transition ease-in-out duration-150">
                    <x-svg.edit class="w-5 h-5 hover:transform hover:scale-125"/>
                </a>
                <a onClick="simulate_benef({{ $sell->purchase->price() }}, {{ $sell->price() }});" title="Simuler le bénéfice" class="no-propagate inline-flex items-center text-sm font-medium text-white hover:text-black transition ease-in-out duration-150">
                    <x-svg.euro class="w-5 h-5 hover:transform hover:scale-125"/>
                </a>
            </div>
        </div>
        <div class="flex flex-col justify-around h-40">
            <p><span class="font-semibold">Etat :</span> {{ $sell->productState->label }}</p>
            <div>
                <p class="flex inline-flex gap-1">
                    <x-svg.help id="histo_offers_{{ $sell->id }}" data-id="{{ $sell->id }}" class="no-propagate icon-clickable icon-xs" onClick="show_histo(this);"/>
                    <span class="font-semibold">Prix :</span> {{ $sell->price() }} €
                </p>
            </div>
            <div id="content_histo_offers_{{ $sell->id }}" class="text-xs hidden">
                @include('partials.sellings.offers', ['offers' => $sell->histo_offers])
            </div>
            <p class="text-sm text-gray-500">sur <a class="link no-propagate" href="{{ $sell->website->url }}" target="_blank">{{ $sell->website->label }}</a>{{ ($sell->sell_state_id === 1 || is_null($sell->date_begin))? '' : ' depuis le '.date('d/m/Y', strtotime($sell->date_begin)) }}</p>
            @if($sell->nb_views > 0)
                <div class="inline-flex gap-1 ml-2">
                    <x-svg.eye_open class="icon-xs"/>
                    <p class="text-xs">{{ $sell->nb_views.' vue' }}{{ ($sell->nb_views > 1)? 's' : '' }}</p>
                </div>
            @endif
        </div>
    @endif
    <div class="absolute bottom-1 right-1 cursor-pointer">
        <x-svg.reply class="icon-xs text-orange-500 hover:transform hover:scale-150 hover:rotate-180 transform rotate-180 transition ease-in-out duration-200"/>
    </div>
</div>