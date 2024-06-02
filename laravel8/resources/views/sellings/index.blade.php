@extends('template')

@section('breadcrumbs')
    {{ Breadcrumbs::render('list', 'selling') }}
@endsection

@section('content')
    <x-Notification type="success" msg="{{ session('info') }}"/>
    
    <h2>Liste des ventes</h2>
    <table class="table-auto">
        <thead>
            <tr>
                <th>Nom du produit</th>
                <th>Etat du produit</th>
                <th>Site web</th>
                <th>Avancée de la vente</th>
                <th>Mon prix & Fdp</th>
                <th>Prix & Fdp confirmés</th>
                <th>Nombre de vues</th>
                <th>Date de début de vente</th>
                <th>Date de vente confirmée</th>
                <th>Date d'envoi du colis</th>
                <th>Avec la boîte</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($sellings as $selling)
                <tr>
                    <td><strong>{{ $selling->product->label }}</strong></td>
                    <td>{{ $selling->productState->label }}</td>
                    <td>{{ $selling->website->label }}</td>
                    <td>{{ $selling->sellState->label }}</td>
                    <td>{{ $selling->price.' & '.$selling->shipping_fees }}</td>
                    <td>{{ (is_null($selling->confirmed_price))? "Non renseigné" : $selling->confirmed_price.' & '.$selling->shipping_fees_payed }}</td>
                    <td>{{ $selling->vues }}</td>
                    <td>{{ (is_null($selling->date_begin))? "Non renseignée" : $selling->date_begin }}</td>
                    <td>{{ (is_null($selling->date_sold))? "Non renseignée" : $selling->date_sold }}</td>
                    <td>{{ (is_null($selling->date_send))? "Non renseignée" : $selling->date_send }}</td>
                    <td>{{ $selling->box? "Avec" : "Sans" }}</td>
                    <td><a class="button is-warning" href="{{ route('sellings.edit', $selling->id) }}">Modifier</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection