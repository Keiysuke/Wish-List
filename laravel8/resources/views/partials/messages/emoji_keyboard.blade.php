@foreach ($sections as $i => $section)
    <div id="emoji_kbd_section_{{ $section->id }}" class="emoji_kbd_section {{ ($i > 0) ? '' : 'show' }}">
    </div>
@endforeach
<input type="hidden" id="list_msg_emoji_section_id" value="0"/>
<input type="hidden" id="max_emoji_sections" value="{{ count($sections) }}"/>
<div class="wrap_vline_emojis my_scrollbar" style="height: {{ (count($sections) > 8) ? '2.55': '2.05' }}rem;">
    <div class="vline_emojis">
    @foreach ($sections as $i => $section)
        <div class="emoji_section_title {{ ($i > 0) ? '' : 'active' }}" data-id="{{ $section->id }}" data-loaded="false">
            <x-tchat.emoji noReaction :emoji="$section->emojis->first()"/>
        </div>
    @endforeach
    </div>
</div>