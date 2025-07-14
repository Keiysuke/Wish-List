<div class="flex inline-flex items-center gap-2 pt-6">
    Lié à<x-svg.big.console class="icon-lg text-blue-600"/>
    {{ $support->label.' ('.$support->alias.')' }}
    <input type="hidden" name="lk_vg_support" value="{{ $template->id }}"/>
</div>