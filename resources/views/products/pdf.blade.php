<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Fiche produit</title>
    <style>
        body { font-family: sans-serif; }
        h2 { text-align: center; }
    </style>
</head>
<body>
    <h2>Fiche du produit - {{ $product->name }}</h2>
    <p><strong>Catégorie :</strong> {{ $product->category->name }}</p>
    <p><strong>Description :</strong> {{ $product->description }}</p>
    <p><strong>Prix :</strong> ${{ number_format($product->price, 2) }}</p>
    <p><strong>Stock :</strong> {{ $product->stock->quantity ?? 0 }}</p>
    <p><strong>Fournisseur :</strong> {{ $product->supplier->first_name }} {{ $product->supplier->last_name }}</p>
    {{-- <p><strong>Image :</strong> <img src="{{ $product->picture }}" style="width: 100px; height: auto;"></p> --}}

</body>
</html>
