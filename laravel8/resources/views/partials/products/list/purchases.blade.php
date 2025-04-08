<div class="h-full mb-5">
    @if(count($purchases) == 0)
        Aucun achat associé
    @else
        <div class="grid grid-cols-4 text-center gap-4">
            @foreach ($purchases as $purchase)
                <div class="thumbnail-recto-verso relative border rounded cursor-pointer hover:shadow-lg transition ease-in-out duration-150">
                    <div class="thumbnail mode-recto" id="thumbnail-{{ @++$cpt }}">
                        @if($purchase->display_type === 'benef')
                            @include('partials.thumbnails.benefice', [$purchase, 'class' => 'layer recto-side', $cpt])
                        @else
                            @php($flip = $purchase->display_type === 'sell' ? 'flip_thumbnail' : '')
                            @include('partials.thumbnails.purchase', [$purchase, 'class' => 'layer recto-side '.$flip, $cpt])
                        @endif
                        @include('partials.thumbnails.selling', ['sell' => $purchase->selling, 'purchase_id' => $purchase->id, 'class' => 'layer verso-side', $cpt])
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>