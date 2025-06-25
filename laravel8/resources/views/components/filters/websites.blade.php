@php($crowdfunding = request('crowdfunding', null))
<div class="relative">
    <p class="relative w-full text-center px-4 border-b-only border-gray-300 bg-gray-200 font-semibold p-1">
        Sites de vente
        <div class="absolute flex gap-4 top-2 right-2">
            <label class="right-2 text-xs">
                Participatifs
                <input class="ml-1" id="check-crowdfunding" type="checkbox" {{ $crowdfunding == 1 ? 'checked' : '' }} />
            </label>
            <label class="text-xs">Dé/cocher tout <input class="ml-1" id="check-all-websites" type="checkbox"/></label>
        </div>
    </p>
    <div class="grid grid-cols-5 gap-x-12 px-8">
        @foreach ($websites as $website)
            <div class="inline-flex">
                <x-Form.Checkbox class="mr-2 mt-1 filter-website" name="website_{{ $website->id }}" data-cfg="{{ $website->is_crowdfunding }}">{{ ($crowdfunding && $website->is_crowdfunding) || is_null($crowdfunding) ? 'checked' : '' }}</x-Form.Checkbox>
                <x-Form.Label for="website-{{ $website->id }}">{{ $website->label }}</x-Form.Label>
            </div>
        @endforeach
    </div>
</div>