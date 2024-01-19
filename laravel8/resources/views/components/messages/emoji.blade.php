<div class="{{ isset($section) ? '' : 'msg_reaction ' }}icon-sm {{ $class ?? '' }}" data-id="{{ $emoji->id }}" data-section-id="{{ $emoji->section->id }}">
    {{ $emoji->label }}
</div>