<div class="{{ $class }} h-full w-full" onClick="toggle_thumbnail({{ $cpt }})">
    <div class="relative bg-orange-500 font-semibold uppercase rounded rounded-b-none text-white p-2">
        Acheté
        <div class="absolute right-2 top-2">
            <a title="Editer l'achat" href="{{ route('purchases.edit', $purchase->id) }}" class="no-propagate inline-flex items-center text-sm font-medium text-white hover:text-black transition ease-in-out duration-150">
                <x-svg.edit class="w-5 h-5 hover:transform hover:scale-125"/>
            </a>
        </div>
    </div>
    <div class="flex flex-col justify-around h-40 py-4">
        <p><span class="font-semibold">Etat :</span> {{ $purchase->productState->label }}</p>
        <p><span class="font-semibold">Prix :</span> {{ $purchase->cost }} €</p>
        <p class="text-sm text-gray-500">via <a class="link no-propagate" href="{{ $purchase->website->url }}" target="_blank">{{ $purchase->website->label }}</a>{{ is_null($purchase->date)? '' : ', le '.date('d/m/Y', strtotime($purchase->date)) }}</p>
    </div>
    <div class="absolute bottom-1 right-1 cursor-pointer">
        <x-svg.reply class="icon-xs text-green-500 hover:transform hover:scale-150 hover:rotate-180 transform rotate-180 transition ease-in-out duration-200"/>
    </div>
</div>
	