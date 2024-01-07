<div class="flex flex-col h-screen gap-6" id="list_benefits">
    @if(count($datas) > 0)
        <div class="flex-grow overflow-auto scrollbar-thin scrollbar-track-gray-400 scrollbar-thumb-gray-700">
            <table class="relative w-full whitespace-nowrap">
                <thead class="sticky -top-1 border">
                    <tr>
                        <x-tables.th label="#" class="text-center"/>
                        <x-tables.th label="Photo"/>
                        <x-tables.th label="Produit"/>
                        <x-tables.th label="Site de vente"/>
                        <x-tables.th label="Payé"/>
                        <x-tables.th label="Douane"/>
                        <x-tables.th label="Vendu"/>
                        <x-tables.th label="Fdp"/>
                        <x-tables.th label="Fdp payés"/>
                        <x-tables.th label="Bénéfice"/>
                    </tr>
                </thead>
                <tbody>
                @foreach($datas as $k => $data)
                    <tr tabindex="0" class="focus:outline-none border border-gray-100 rounded">
                        <x-tables.td label="# {{ $k }}" class="text-center"/>
                        <x-tables.td>
                            <a href="{{ route('products.show', $data->product_id) }}">
                                <img class="h-10" src="{{ asset(config('images.path_products').'/'.$data->product_id.'/'.$data->product->photos()->firstWhere('ordered', 1)->label) }}"/>
                            </a>
                        </x-tables.td>
                        <x-tables.td :label="$data->product->label" class="text-xs"/>
                        <x-tables.td>
                            <a class="link" href="{{ $data->website->url }}" target="_blank">{{ $data->website->label }}</a>
                        </x-tables.td>
                        <x-tables.td :label="$data->cost" class="text-center"/>
                        <x-tables.td :label="$data->customs" class="text-center"/>
                        <x-tables.td :label="$data->sold_price" class="text-center"/>
                        <x-tables.td :label="$data->shipping_fees" class="text-center"/>
                        <x-tables.td :label="$data->shipping_fees_payed" class="text-center"/>
                        <x-tables.td :label="$data->benefits" class="text-center" benef/>
                    </tr>
                    <tr class="h-1"></tr>
                @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <x-tables.th label="Totaux"/>
                        <x-tables.th label=""/>
                        <x-tables.th label=""/>
                        <x-tables.th label="Payé" lowcase/>
                        <x-tables.th :label="$totals['paid']" class="text-center"/>
                        <x-tables.th label="Vendus pour" lowcase/>
                        <x-tables.th :label="$totals['sold']" class="text-center"/>
                        <x-tables.th label=""/>
                        <x-tables.th label="Bénéfices" lowcase/>
                        <x-tables.th :label="$totals['benefits']" class="text-center"/>
                    </tr>
                </tfoot>
            </table>
        </div>
    @else
        Aucun historique trouvé...
    @endif
</div>

@if(count($datas) > 0)
    <footer id="paginate" class="card-footer flex justify-center p-4">
        {{ $datas->links() }}
    </footer>
@endif