<div class="flex flex-col h-screen gap-6" id="list-benefits">
    @if(count($datas) > 0)
        <div class="flex-grow overflow-auto scrollbar-thin scrollbar-track-gray-400 scrollbar-thumb-gray-700">
            <table class="relative w-full whitespace-nowrap">
                <thead class="sticky -top-1 border">
                    <tr>
                        <x-Tables.Th label="#" class="text-center"/>
                        <x-Tables.Th label="Photo"/>
                        <x-Tables.Th label="Produit"/>
                        <x-Tables.Th label="Site de vente"/>
                        <x-Tables.Th label="Payé"/>
                        <x-Tables.Th label="Douane"/>
                        <x-Tables.Th label="Vendu"/>
                        <x-Tables.Th label="Fdp"/>
                        <x-Tables.Th label="Fdp payés"/>
                        <x-Tables.Th label="Bénéfice"/>
                    </tr>
                </thead>
                <tbody>
                @foreach($datas as $k => $data)
                    @php($data->product->setFirstPhoto())
                    <tr tabindex="0" class="focus:outline-none border border-gray-100 rounded">
                        <x-Tables.Td label="# {{ $k }}" class="text-center"/>
                        <x-Tables.Td>
                            <a href="{{ route('products.show', $data->product_id) }}">
                                <img class="h-10" src="{{ $data->product->pict }}"/>
                            </a>
                        </x-Tables.Td>
                        <x-Tables.Td :label="$data->product->label" class="text-xs"/>
                        <x-Tables.Td>
                            <a class="link" href="{{ $data->website->url }}" target="_blank">{{ $data->website->label }}</a>
                        </x-Tables.Td>
                        <x-Tables.Td :label="$data->cost" class="text-center"/>
                        <x-Tables.Td :label="$data->customs" class="text-center"/>
                        <x-Tables.Td :label="$data->sold_price" class="text-center"/>
                        <x-Tables.Td :label="$data->shipping_fees" class="text-center"/>
                        <x-Tables.Td :label="$data->shipping_fees_payed" class="text-center"/>
                        <x-tables.td :label="$data->benefits" class="text-center" benef/>
                    </tr>
                    <tr class="h-1"></tr>
                @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <x-Tables.Th label="Totaux"/>
                        <x-Tables.Th label=""/>
                        <x-Tables.Th label=""/>
                        <x-Tables.Th label="Payé" lowcase/>
                        <x-Tables.Th :label="$totals['paid']" class="text-center"/>
                        <x-Tables.Th label="Vendus pour" lowcase/>
                        <x-Tables.Th :label="$totals['sold']" class="text-center"/>
                        <x-Tables.Th label=""/>
                        <x-Tables.Th label="Bénéfices" lowcase/>
                        <x-Tables.Th :label="$totals['benefits']" class="text-center"/>
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