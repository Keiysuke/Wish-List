<div class="flex w-full justify-center gap-1 border-b border-blue-500 mb-2 relative">
    <div class="absolute left-0 top-2 inline-flex gap-1">
        <span title="Agrandir" class="title-icon cursor-pointer border-blue-500" onClick="extendListMsg();">
            <x-svg.big.extand class="icon-xs"/>
        </span>
    </div>
    <span class="border-2 border-b-0 rounded rounded-b-none p-2 bg-blue-500 text-white font-semibold inline-flex ml-1 gap-1">
        <x-svg.msg title="Messages de la liste actuelle" class="icon-xs"/> Messages de la liste
    </span>
    <div class="absolute right-0 top-2 inline-flex gap-1">
        <span id="show-pin" title="Messages épinglés" class="title-icon" onClick="showMsg();">
            <x-svg.pin class="icon-xs"/>
        </span>
        <span title="Supprimer tous les messages" class="title-icon heart cursor-pointer border-blue-500" onClick="delListMsg(0);">
            <x-svg.trash class="icon-xs"/>
        </span>
    </div>
</div>
<div id="wrap-list-msg">
    <div id="v-list-msg" class="h-120 my-scrollbar">
        @include('components.Tchat.MessagesList', $messages)
    </div>
    <div id="wrap-writer">
        <x-Tchat.AnswerTo id="list-answer-to"/>
        <x-Tchat.CancelEdit id="list-cancel-edit"/>
        <input type="hidden" id="list-answer-id" value="0"/>
        <input type="hidden" id="list-msg-reaction" value="0"/>
        <input type="hidden" id="list-edit-id" value="0"/>
        <x-Form.Textarea id="list-msg-to-send" name="list_msg_to_send"/>
        <div id="list-msg-emoji-sections">
            @include('partials.messages.emoji_keyboard')
        </div>
        <div class="flex items-center gap-2">
            <x-Form.Btn type="submit" name="sendListMsg" class="w-full mt-2" onClick="sendMsg();">Envoyer</x-Form.Btn>
            <x-Tchat.Emoji noReaction :emoji="$emojiOff" id="emoji-off" class="btn-emoji-kbd icon-clickable pt-2" onClick="toggleEmojiKeyboard(-1);"/>
            <x-Tchat.Emoji noReaction :emoji="$emojiOn" id="emoji-on" class="btn-emoji-kbd icon-clickable pt-2 hidden" onClick="toggleEmojiKeyboard(-1);"/>
        </div>
    </div>
</div>
