@if(count($offers) === 0)
    <p>Aucune autre offre...</p>
@else
    @foreach($offers as $offer)
        <p>{{ $offer->price }} € le {{ date('d/m/Y', strtotime($offer->day)) }}</p>
    @endforeach
@endif