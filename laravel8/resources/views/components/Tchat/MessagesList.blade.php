@php($prevUser = 0)
@php($odd = false)
@foreach($messages as $message)
    @if($prevUser > 0 && $message->user_id != $prevUser)
        @php($odd = !$odd)
    @endif
    @php($prevUser = $message->user_id)
    <x-Tchat.Message :message="$message" :odd="$odd"/>
@endforeach