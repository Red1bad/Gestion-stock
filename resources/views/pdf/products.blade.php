{{-- <!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Mon PDF</title>
    <style>
        .content {
            text-align: center;
            background-color: blue
        }
        h1 {
            color: red;
            font-size: 3em;
        }
    </style>
</head>
<body>
    <div class="content">
        <h1>Hello World</h1>
    </div>
</body>
</html> --}}











<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Liste des Produits</title>
    <style>
        body { font-family: sans-serif; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        h1 { text-align: center; margin-bottom: 20px; }

    </style>
</head>
<body>
    {{-- <img src="{{ asset('images/logo.png') }}" alt="Logo" style="width: 150px; margin-bottom: 20px;"> --}}
    <img src="{{ public_path('images/logo.png') }}" alt="Logo" style="width: 90px;">
    <h1>Liste des Produits</h1>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Category</th>
                <th>Price</th>
                <th>Stock</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $index => $product)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->category->name }}</td>
                    <td>${{ number_format($product->price, 2) }}</td>
                    <td>{{ $product->stock->quantity ?? 0 }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>










