<div {{ isset($id) ? 'id=' . $id : '' }} 
    class="{{ isset($noReaction) ? '' : 'msg-reaction ' }} {{ $class ?? '' }}" 
    data-id="{{ $emoji->id }}" 
    data-section-id="{{ $emoji->section->id }}" 
    {{ isset($onClick) ? 'onClick=' . $onClick : '' }}
    >
    {{ $emoji->label }}
</div>