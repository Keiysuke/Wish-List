<div>
    @if ($yours)
        <div>
            <x-svg.edit class="icon-xs"/>
            Editer
        </div>
    @endif
    <div onClick="replyTo('{{ $msg_id }}', '{{ addslashes($answer_to) }}');">
        <x-svg.reply class="icon-xs"/>
        Répondre
    </div>
    @if ($yours)
        <div class="trash" onClick="delListMsg('{{ $msg_id }}');">
            <x-svg.trash class="icon-xs trash"/>
            Supprimer
        </div>
    @endif
    <div class="pin {{ ($pin ? 'is-pin' : '') }}" onClick="pin_msg('{{ $msg_id }}');">
        <x-svg.pin id="pin-msg-icon-{{ $msg_id }}" class="icon-xs {{ ($pin ? 'is-pin' : '') }}" />
        {{ $pin ? 'Désé' : 'E' }}pingler
    </div>
</div>