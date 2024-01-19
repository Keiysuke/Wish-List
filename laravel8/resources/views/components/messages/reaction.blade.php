<div id="msg_{{ $r->message_id }}_reaction_{{ $r->emoji->id }}" class="msg_reaction icon-lg" data-message-id="{{ $r->message_id }}" data-emoji-id="{{ $r->emoji->id }}">
    {{ $r->emoji->label }}
</div>