@foreach ($sections as $i => $section)
    <div id="emoji-kbd-section{{ $section->id }}" class="emoji-kbd-section {{ ($i > 0) ? '' : 'show' }}">
    </div>
@endforeach
<input type="hidden" id="list-msg-emoji-section-id" value="0"/>
<input type="hidden" id="max-emoji-sections" value="{{ count($sections) }}"/>
<div class="wrap-v-line-emojis my-scrollbar" style="height: {{ (count($sections) > 8) ? '2.55': '2.05' }}rem;">
    <div class="v-line-emojis">
    @foreach ($sections as $i => $section)
        <div class="emoji-section-title {{ ($i > 0) ? '' : 'active' }}" data-id="{{ $section->id }}" data-loaded="false">
            <x-Tchat.Emoji noReaction :emoji="$section->emojis->first()"/>
        </div>
    @endforeach
    </div>
</div>