<?php

use App\Services\ProductService;

$file_name = "list.xls";
header("Content-Disposition: attachment; filename=\"$file_name\"");
header("Content-Type: application/vnd.ms-excel");

echo "Produit\t";
echo "Exemplaires\t";
echo "Prix Unitaire\t";
echo "Lien\t\n";

foreach ($products as $product) {
    $offer = ProductService::bestWebsiteOffer($product);
    echo $product->label."\t";
    echo $product->nb."\t";
    echo $offer->price."\t";
    echo $offer->url."\t\n";
}
?>