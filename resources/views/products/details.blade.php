@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card">
        <div class="card-header">
            <h3>Détails du produit : <strong>{{ $product->name }}</strong></h3>
        </div>
        <div class="card-body">
            <p><strong>Catégorie :</strong> {{ $product->category->name }}</p>
            <p><strong>Description :</strong> {{ $product->description }}</p>
            <p><strong>Prix :</strong> ${{ number_format($product->price, 2) }}</p>
            <p><strong>Stock :</strong> {{ $product->stock->quantity ?? 0 }}</p>
            <p><strong>Fournisseur :</strong> {{ $product->supplier->first_name }} {{ $product->supplier->last_name }}</p>
            {{-- <p><strong>Image :</strong> <img src="{{ $product->picture }}" style="width: 100px; height: auto;"></p> --}}

            <a href="{{ route('products.downloadPdf', $product->id) }}" class="btn btn-outline-primary mt-3">
                <i class="bi bi-download"></i> Télécharger PDF
            </a>
        </div>
    </div>
</div>
@endsection
