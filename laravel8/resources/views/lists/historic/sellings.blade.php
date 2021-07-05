@php($month = null)
<div class="flex flex-col gap-6" id="list_sellings">
    @if(count($datas) > 0)
        @foreach($datas as $data)
            @if(is_null($month) || $month != $data->month)
                @php($month = $data->month)
                <h2 class="text-center mt-4">{{ __($data->month).' '.$data->year.' ('.$totals[$data->year.'_'.$data->month].' €)' }}</h2>
            @endif
            <div class="flex justify-between h-full border rounded hover:shadow-lg transition ease-in-out duration-150" id="element_{{ $data->kind.'_'.$data->id }}">
                <div class="relative w-1/12">
                    <a href="{{ route('products.show', $data->product_id) }}">
                        <div class="product_pict rounded rounded-r-none" style="background-image: url({{ asset(config('images.path_products').'/'.$data->product_id.'/'.$data->product->photos()->firstWhere('ordered', 1)->label) }})"></div>
                    </a>
                </div>
                <div class="flex flex-col w-11/12">
                    <div class="flex justify-between border-1 border-b border-gray-100 bg-gray-200 rounded">
                        <p class="text-lg font-semibold text-black py-1 pl-4 border-b border-gray-300 bg-gray-200">{{ $data->product->label }}</p>
                        <div class="icons_container">
                            <a href="{{ route('products.show', $data->product->id) }}" class="inline-flex hover:text-blue-500" title="Fiche du produit">
                                <x-svg.eye_open class="icon-xs"/>
                            </a>
                        </div>
                    </div>
                    <div class="flex flex-col justify-center h-full px-4">
                        <p><span class="italic">{{ $data->date_show }}</span> 
                            sur <a class="link" href="{{ $data->website->url }}" target="_blank">{{ $data->website->label }}</a> 
                            pour <span class="text-blue-500 font-bold">{{ $data->cost }} €</span>
                        </p>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        Aucune vente trouvée...
    @endif
</div>

@if(count($datas) > 0)
    <footer id="paginate" class="card-footer flex justify-center p-4">
        {{ $datas->links() }}
    </footer>
@endif