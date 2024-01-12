<div class="flex w-full justify-center gap-1 border-b border-blue-500 mb-2 relative">
    <div class="absolute left-0 top-2 inline-flex gap-1">
        <span id="show_pin" title="Messages épinglés" class="title-icon" onClick="show_msg();">
            <x-svg.pin class="icon-xs"/>
        </span>
    </div>
    <span class="border-2 border-b-0 rounded rounded-b-none p-2 bg-blue-500 text-white font-semibold inline-flex ml-1 gap-1">
        <x-svg.msg title="Messages de la liste actuelle" class="icon-xs"/> Messages de la liste
    </span>
    <div class="absolute right-0 top-2 inline-flex gap-1">
        <span title="Agrandir" class="title-icon cursor-pointer border-blue-500" onClick="extendListMsg();">
            <x-svg.big.extand class="icon-xs"/>
        </span>
        <span title="Supprimer tous les messages" class="title-icon heart cursor-pointer border-blue-500" onClick="del_list_msg(0);">
            <x-svg.trash class="icon-xs"/>
        </span>
    </div>
</div>
<div id="wrap_list_msg">
    <div id="v_list_msg" class="h-120 my_scrollbar">
        @include('components.messages.list', $messages)
    </div>
    <div id="wrap_writer">
        <x-messages.answer_to id="list_answer_to"/>
        <input type="hidden" id="list_answer_id" value="0"/>
        <x-form.textarea name="list_msg_to_send" class="focus_list_messages"/>
        <x-form.btn type="submit" name="send_list_msg" class="focus_list_messages mt-2" onClick="send_msg();">Envoyer</x-form.btn>
    </div>
</div>
