@extends('template')

@section('breadcrumbs')
    {{ Breadcrumbs::render('list', 'purchase') }}
@endsection

@section('content')
    <x-Notification type="success" msg="{{ session('info') }}"/>
    
    <h2>Liste des achats</h2>
    <a class="button is-info" href="{{ route('purchases.create') }}">Ajouter un nouvel achat</a>
    <table class="table-auto">
        <thead>
            <tr>
                <th>Nom du produit</th>
                <th>Etat du produit</th>
                <th>Site web</th>
                <th>coût sur le site</th>
                <th>Date de l'achat</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($purchases as $purchase)
                <tr>
                    <td><strong>{{ $purchase->product->label }}</strong></td>
                    <td>{{ $purchase->productState->label }}</td>
                    <td>{{ $purchase->website->label }}</td>
                    <td>{{ $purchase->cost }}</td>
                    <td>{{ $purchase->date }}</td>
                    <td><a class="button is-warning" href="{{ route('purchases.edit', $purchase->id) }}">Modifier</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection