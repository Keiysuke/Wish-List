@if($product->crowdfundings && $product->crowdfundings->count())
    <div class="mt-4">
        <ul class="list-disc ml-6">
            @foreach($product->crowdfundings as $crowdfunding)
                <li>
                    <a class="link" href="{{ $crowdfunding->project_url }}" target="_blank" class="text-blue-600 underline">{{ $crowdfunding->website->label }}</a>
                    <span>({{ $crowdfunding->state->label }})</span>
                    
                    <a title="Editer le projet" href="{{ route('crowdfundings.edit', $crowdfunding) }}" class="inline-flex text-gray-700">
                        <x-svg.edit class="icon-xs icon-clickable"/>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
@endif
