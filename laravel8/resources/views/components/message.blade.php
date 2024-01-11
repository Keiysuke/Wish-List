<div id="list_msg_{{ $message->id }}" class="wrap_list_msg {{ $class ?? '' }}">
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
    <div class="msg_icons flex gap-1 absolute right-1 top-1">
        @if ($message->yours())
            <x-svg.edit class="icon-xs icon-clickable"/>
            <x-svg.trash class="no-propagate icon-xs icon-clickable trash" onClick="del_list_msg('{{ $message->id }}');"/>
            <x-svg.pin id="pin_msg_icon_{{ $message->id }}" class="no-propagate icon-xs icon-clickable {{ ($message->pin ? 'is_pin' : '') }}" onClick="pin_msg('{{ $message->id }}');"/>
        @endif
    </div>
    <x-svg.reply class="absolute right-1 bottom-1 icon-xs icon-clickable" onClick="replyTo('{{ $message->id }}', '{{ addslashes($message->user->name) }}');"/>
</div>