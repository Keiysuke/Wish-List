@foreach ($sections as $i => $section)
    <div id="emoji_kbd_section_{{ $section->id }}" class="emoji_kbd_section {{ ($i > 0) ? '' : 'show' }}">
        @foreach ($section->emojis as $emoji)
            <x-messages.emoji :emoji="$emoji"/>
        @endforeach
    </div>
@endforeach
<input type="hidden" id="list_msg_emoji_section_id" value="1"/>
<div class="wrap_vline_emojis {{ (count($sections) > 8) ? 'my_scrollbar h-12': 'h-8' }}">
    <div class="vline_emojis">
    @foreach ($sections as $i => $section)
        <div class="emoji_section_title {{ ($i > 0) ? '' : 'active' }}" data-id="{{ $section->id }}">
            <x-messages.emoji section :emoji="$section->emojis->first()"/>
        </div>
    @endforeach
    </div>
</div>