@php($payed = $purchase->calculatePrice())
@php($sell = $purchase->selling ?? null)
@php($sold = is_null($sell)? null : $sell->price())
<div class="{{ $class }} h-full w-full" onClick="toggle_thumbnail({{ $cpt }})">
    <div class="relative bg-orange-500 font-semibold uppercase rounded rounded-b-none text-white p-2">
        <div class="absolute left-2 top-3">
            <x-svg.cart class="w-5 h-5"/>
        </div>
        Acheté
        <div class="absolute right-2 top-2">
            <a title="Editer l'achat" href="{{ route('purchases.edit', $purchase->id) }}" class="no-propagate inline-flex items-center text-sm font-medium text-white hover:text-black transition ease-in-out duration-150">
                <x-svg.edit class="w-5 h-5 hover:transform hover:scale-125"/>
            </a>
            <a onClick="simulateBenef({{ $payed + $purchase->customs }}, {{ $sold }});" title="Simuler le bénéfice" class="no-propagate inline-flex items-center text-sm font-medium text-white hover:text-black transition ease-in-out duration-150">
                <x-svg.euro class="w-5 h-5 hover:transform hover:scale-125"/>
            </a>
        </div>
    </div>
    <div class="flex flex-col justify-around h-40 py-4">
        <p><span class="font-semibold">Etat :</span> {{ $purchase->productState->label }}</p>
        <p><span class="font-semibold">Prix :</span> {{ $payed }} €</p>
        @if($purchase->discount > 0)
            <p class="text-sm text-green-400"><span class="font-semibold">Réduction :</span> {{ $purchase->discount }} €</p>
        @endif
        @if(!is_null($purchase->customs))
            <p class="text-sm text-red-400"><span class="font-semibold">Douane :</span> {{ $purchase->customs }} €</p>
        @endif
        <p class="text-sm text-gray-500">via <a class="link no-propagate" href="{{ $purchase->website->url }}" target="_blank">{{ $purchase->website->label }}</a>{{ ', le '.$purchase->date() }}</p>
    </div>
    <div class="absolute bottom-1 right-1 cursor-pointer">
        <x-svg.reply class="icon-xs text-green-500 hover:transform hover:scale-150 hover:rotate-180 transform rotate-180 transition ease-in-out duration-200"/>
    </div>
</div>
	