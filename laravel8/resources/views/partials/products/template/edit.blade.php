@php($templated = isset($template))
@php($type = ($template->type ?? old('template_type')))
<div class="w-1/5">
    <x-Form.Label for="template-type" block>Type du produit</x-Form.Label>
    <select name="template_type" id="template-type" class="pl-2 h-10 block w-full rounded-md bg-gray-100 border-transparent">
        <option value="none">Aucun</option>
        <option value="video_game" @if(strcmp($type, 'video_game') === 0) selected @endif>Jeu Vidéo</option>
        <option value="vg_support" @if(strcmp($type, 'vg_support') === 0) selected @endif>Support de JV</option>
        <option value="publisher" @if(strcmp($type, 'publisher') === 0) selected @endif>Livre</option>
    </select>
    @if($templated)
        @error('lk_video_game')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        @error('lk_vg_support')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        @error('lk_publisher')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    @else
        @error('template_type')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    @endif
</div>
@if ($templated && $vg = $product->video_game)
    @include('partials.products.template.linked.vg', compact($template, $vg))
@elseif ($templated && $support = $product->vgSupport)
    @include('partials.products.template.linked.support', compact($template, $support))
@elseif ($templated && $book = $product->book)
    @include('partials.products.template.linked.book', compact($template, $book))
@else
    <div id="wrap-lk-video-game" class="w-2/5 hidden">
        <x-Form.Label for="lk-video-game" required block create="{{ route('video_games.create') }}">Associer le jeu vidéo</x-Form.Label>
        <select name="lk_video_game" id="lk-video-game" data-url="{{ route('autocomplete') }}" value="{{ old('lk_video_game') }}" class="w-full"></select>
    </div>
    <div id="wrap-lk-vg-support" class="w-2/5 hidden">
        <x-Form.Label for="lk-vg-support" required block create="{{ route('vg_supports.create') }}">Associer le support</x-Form.Label>
        <select name="lk_vg_support" id="lk-vg-support" data-url="{{ route('autocomplete') }}" value="{{ old('lk_vg_support') }}" class="w-full"></select>
    </div>
    <div id="wrap-lk-publisher" class="w-2/5 hidden">
        <x-Form.Label for="lk-publisher" required block create="{{ route('book_publishers.create') }}">Associer la maison d'édition</x-Form.Label>
        <select name="lk_publisher" id="lk-publisher" data-url="{{ route('autocomplete') }}" value="{{ old('lk_publisher') }}" class="w-full"></select>
    </div>
@endif