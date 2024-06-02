@foreach($messages as $message)
    <x-Tchat.Message :message="$message"/>
@endforeach