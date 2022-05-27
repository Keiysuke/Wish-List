<?php
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
use Illuminate\Support\Facades\Route;

// Home
Breadcrumbs::for('home', function ($trail) {
    $trail->push('Accueil', route('my_products'));
});

//Sitemap
Breadcrumbs::for('sitemap', function ($trail) {
    $trail->parent('home');
    $trail->push('Plan du site', route('sitemap'));
});

//Home > Produits
Breadcrumbs::for('list', function ($trail, $elem) {
    $trail->parent('home');
    $all = ['website' => 'Sites', 'product' => 'Produits', 'purchase' => 'Achats', 'selling' => 'Ventes', 'photo' => 'Photos', 'list' => 'Listes', 'video_game' => 'Jeux Vidéo'];
    $trail->push(str_replace($elem, $elem, $all[$elem]), route((!strcmp($elem, 'product')? 'my_products' : $elem.'s.index')));
});

//Home > Sites > Amazon
Breadcrumbs::for('create', function ($trail, $elem) {
    $trail->parent('list', $elem);
    $trail->push('Création', route($elem.'s.create'));
});

//Home > Produits > Uncharted 4
Breadcrumbs::for('show', function ($trail, $elem, $data) {
    $trail->parent('list', $elem);
    $label = isset($data->label)? ((strlen($data->label) > 30)? substr($data->label, 0, 30).'...' : $data->label) : '';
    if(Route::has($elem.'s.show'))
        $trail->push($label, route($elem.'s.show', $data->id));
    else
        $trail->push($label);
});

//Home > Sites > Amazon
Breadcrumbs::for('edit', function ($trail, $elem, $data) {
    $trail->parent('show', $elem, $data);
    $trail->push('Edition', route($elem.'s.edit', $data->id));
});

//Home > Produits > Uncharted 4 > Edition des photos
Breadcrumbs::for('edit_product_photos', function ($trail, $product) {
    $trail->parent('show', 'product', $product);
    $trail->push('Edition des photos', route('product_photos.edit', $product));
});

//Home > Produits > Uncharted 4 > Lier un site
Breadcrumbs::for('create_product_website', function ($trail, $product) {
    $trail->parent('show', 'product', $product);
    $trail->push('Lier un site', route('product_websites.create', $product));
});

//Home > Produits > Uncharted 4 > Edition de site lié
Breadcrumbs::for('edit_product_website', function ($trail, $product_website) {
    $trail->parent('show', 'product', $product_website->product);
    $trail->push('Edition de site lié', route('product_websites.edit', $product_website));
});

//Home > Produits > Uncharted 4 > Achats > Création
Breadcrumbs::for('create_purchase', function ($trail, $product) {
    $trail->parent('show', 'product', $product);
    $trail->push('Création d\'un achat', route('purchases.create', $product));
});

//Home > Produits > Uncharted 4 > Achats > Edition
Breadcrumbs::for('edit_purchase', function ($trail, $purchase, $product) {
    $trail->parent('show', 'product', $product);
    $trail->push('Edition d\'un achat', route('purchases.edit', [$product, $purchase]));
});

//Home > Produits > Uncharted 4 > Ventes > Création d'une vente
Breadcrumbs::for('create_selling', function ($trail, $selling, $product) {
    $trail->parent('show', 'product', $product);
    $trail->push('Création d\'une vente', route('sellings.create', $selling));
});

//Home > Produits > Uncharted 4 > Ventes > Edition d'une vente
Breadcrumbs::for('edit_selling', function ($trail, $selling, $product) {
    $trail->parent('show', 'product', $product);
    $trail->push('Edition d\'une vente', route('sellings.edit', $selling));
});

//Home > Mon historique
Breadcrumbs::for('historic', function ($trail, $kind) {
    $trail->parent('home');
    $end_link = $kind === 'purchases' ? "d'achats" : "de ventes";
    $trail->push('Mon historique '.$end_link, route('user_historic', $kind));
});

//Home > Mes achats > Nouvel achat groupé
Breadcrumbs::for('create_group_buy', function ($trail) {
    $trail->parent('historic', 'purchases');
    $trail->push('Nouvel achat groupé', route('group_buys.create'));
});

//Home > Mes achats > Edition d'un achat groupé
Breadcrumbs::for('edit_group_buy', function ($trail, $group_buy) {
    $trail->parent('historic', 'purchases');
    $trail->push('Edition d\'un achat groupé', route('group_buys.edit', $group_buy));
});
