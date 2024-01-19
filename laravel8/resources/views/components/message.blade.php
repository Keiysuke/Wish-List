<div class="flex flex-col gap-1">
    <div id="list_msg_{{ $message->id }}" class="content_list_msg {{ $class ?? '' }}">
        @if($message->answer_to_id > 0)
            @php($answer = $message->answer_to)
            <div class="cursor-pointer replying_to" onClick="flashOriginalMsg({{ $answer->id }});">
                <x-svg.reply class="icon-xs scaleX"/>
                <span class="font-bold">{{ $answer->user->name }}</span>
                {{ $answer->replyingToMsg() }}
            </div>
        @endif

        <div class="flex items-center gap-2">
            <div class="user_avatar">{{ $message->user->name[0] }}</div>
            <span>{{ $message->user->name }}</span>
        </div>
        <div>{{ $message->message }}</div>
        <div class="msg_icons flex gap-1 absolute right-0 top-1">
            <x-svg.big.v_dot class="icon-sm icon-clickable" onClick="openMsgMenu(event, '{{ $message->id }}', '{{ $message->yours() }}', '{{ $message->pin }}', '{{ addslashes($message->user->name) }}');"/>
        </div>
        <x-svg.happy id="react_msg_icon_{{ $message->id }}" class="list_msg_react_btn icon-xs icon-clickable" onClick="toggleEmojiMsg('{{ $message->id }}');"/>
        <div class="vline_reactions">@include('components.messages.reactions', ['reactions' => $message->allReactions])</div>
    </div>
</div>