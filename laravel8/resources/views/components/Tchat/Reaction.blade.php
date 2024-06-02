<div 
    id="msg-{{ $r->message_id }}-reaction-{{ $r->emoji->id }}" 
    class="msg-reaction icon-lg" 
    data-message-id="{{ $r->message_id }}" 
    data-emoji-id="{{ $r->emoji->id }}"
    >
    {{ $r->emoji->label }}
</div>