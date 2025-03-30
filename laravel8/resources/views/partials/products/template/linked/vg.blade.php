@php($label = $vg->video_game->label.' ('.$vg->vg_support->alias.')')
<div class="flex inline-flex items-center gap-2 pt-6">
    Associé à<x-svg.big.vg_controller class="icon-sm text-red-600"/>
    <a href="{{ route('video_games.show', $vg->video_game_id) }}" class="font-bold link">{{ $label }}</a>
    <input type="hidden" name="lk_video_game" value="{{ $template->id }}"/>
    <input type="hidden" name="lk_vg_support" value="{{ $template->support_id }}"/>
</div>