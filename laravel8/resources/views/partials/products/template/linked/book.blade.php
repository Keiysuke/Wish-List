@php($publisher = $book->publisher)
<div class="flex inline-flex items-center gap-2 pt-6">
    Lié à<x-svg.big.book class="icon-sm text-warm_gray-600"/>
    <a href="{{ $publisher->website->url }}" class="font-bold link">{{ $publisher->label }}</a>
    <input type="hidden" name="lk_publisher" value="{{ $template->id }}"/>
</div>