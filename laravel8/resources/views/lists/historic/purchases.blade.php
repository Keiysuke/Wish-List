@php($month = null)
<div class="flex flex-col gap-6" id="list-purchases">
    @if(count($datas) > 0)
        @foreach($datas as $data)
            @if(is_null($month) || $month != $data->month)
                @php($month = $data->month)
                <h2 class="text-center mt-4">{{ __($data->month).' '.$data->year.' ('.$totals[$data->year.'_'.$data->month].' €)' }}</h2>
            @endif
            <div class="flex justify-between h-full border rounded hover:shadow-lg transition ease-in-out duration-150" id="element-{{ $data->kind.'-'.$data->id }}">
                @if($data->simple)
                    @php($data->product->setFirstPhoto())
                    <div class="relative w-1/12">
                        <a href="{{ route('products.show', $data->product_id) }}">
                            <div class="product-pict rounded rounded-r-none" style="background-image: url({{ $data->product->pict }})"></div>
                        </a>
                    </div>
                    <div class="flex flex-col w-11/12">
                        <div class="flex justify-between border-1 border-b border-gray-100 bg-gray-200 rounded">
                            <p class="text-sm font-semibold text-black py-1 pl-4 border-b border-gray-300 bg-gray-200">{{ $data->product->label }}</p>
                            <div class="icons-container">
                                <a href="{{ route('products.show', $data->product->id) }}" class="inline-flex hover:text-blue-500" title="Fiche du produit">
                                    <x-svg.eye_open class="icon-xs"/>
                                </a>
                            </div>
                        </div>
                        <div class="flex flex-col justify-center h-full px-4">
                            <p><span class="italic">{{ $data->date_show }}</span>
                                sur <a class="link" href="{{ $data->website->url }}" target="_blank">{{ $data->website->label }}</a> 
                                pour <span class="text-{{ ($data->discount > 0)? 'green' : 'blue' }}-500 font-bold">{{ $data->cost - $data->discount }} €</span>
                            </p>
                        </div>
                    </div>
                @else
                    <div class="flex flex-col w-full border-1 border-b border-gray-100 rounded">
                        <p class="relative flex justify-center items-center mb-2 text-sm font-semibold text-black py-1 border-b border-gray-300 bg-gray-200">
                            <span class="flex inline-flex items-center absolute left-2">
                                <span class="text-base" title="{{ 'Coût + Fdp - Réduc : '.$data->global_cost.' + '.$data->shipping_fees.' - '.$data->discount }}">{{ $data->cost.' €' }}</span><x-Utils.VLine height="3"/> <a class="link" href="{{ $data->purchases->first()->website->url }}" target="_blank">{{ $data->purchases->first()->website->label }}</a>
                            </span>
                            <span class="text-lg">{{ is_null($data->label)? __("Group purchase") : $data->label }}</span>
                            <span class="absolute right-2 font-normal italic">
                                {{ $data->date_show }}
                                <a href="{{ route('group_buys.edit', $data->id) }}" class="inline-flex hover:text-blue-500" title="Editer l'achat groupé">
                                    <x-svg.edit class="icon-xs"/>
                                </a>
                            </span>
                        </p>
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                        @foreach ($data->purchases as $purchase)
                            @php($purchase->product->setFirstPhoto())
                            @php($img = asset($purchase->product->pict))
                            <div class="flex justify-center gap-4 border-1 border-gray-300" id="purchase_{{ $purchase->id }}">
                                <div class="flex flex-col items-center relative">
                                    <a href="{{ route('products.show', $purchase->product_id) }}">
                                        <img class="{{ (count($data->purchases) > 1)? 'h-52' : 'h-40' }} transform hover:scale-75 transition ease-in-out duration-200" src="{{ $img }}"/>
                                        <p class="absolute top-6 left-0 border-l-0 p-2 px-4 bg-{{ ($purchase->cost > 0 && !$purchase->discount)? 'red' : 'green' }}-500 text-white font-semibold border-2 border-white">{{ $purchase->nb * ($purchase->cost - $purchase->discount) }} €</p>
                                        @if($purchase->nb > 1)
                                            <p class="absolute top-6 right-0 border-r-0 p-2 px-4 bg-blue-600 text-white font-semibold border-2 border-white">{{ 'x'.$purchase->nb }}</p>
                                        @endif
                                    </a>
                                    <div class="w-full {{ (count($data->purchases) > 1)? 'absolute' : '' }} text-center bg-white bottom-0">
                                        <p class="text-sm font-semibold text-black p-1">{{ $purchase->product->label }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        </div>
                    </div>
                @endif
            </div>
        @endforeach
    @else
        Aucun achat trouvé...
    @endif
</div>

@if(count($datas) > 0)
    <footer id="paginate" class="card-footer flex justify-center p-4">
        {{ $datas->links() }}
    </footer>
@endif