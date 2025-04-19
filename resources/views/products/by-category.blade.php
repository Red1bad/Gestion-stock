{{-- @extends('layouts.app')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-4">Products By Category</h2>

        <!-- Sélection de la catégorie -->
        <form method="GET" action="{{ route('products.category') }}" class="mb-4">
            <label for="category" class="block text-gray-700 font-medium">Choose a Category:</label>
            <select name="category_id" id="category"
                class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">-- Select Category --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $selectedCategory == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            <button type="submit"
                class="mt-2 bg-indigo-500 text-white px-4 py-2 rounded-md hover:bg-indigo-600">
                Show Products
            </button>
        </form>

        <!-- Affichage des produits -->
        @if (!empty($productsByCategory))
            <h3 class="text-lg font-semibold mb-2">Products in Selected Category:</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($productsByCategory as $product)
                    <div class="bg-gray-100 p-4 rounded-lg shadow">
                        <h4 class="font-bold">{{ $product->name }}</h4>
                        <p class="text-gray-600">{{ Str::limit($product->description, 50) }}</p>
                        <p class="text-green-600 font-bold">Price: ${{ $product->price }}</p>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500">No products found in this category.</p>
        @endif

    </div>
@endsection --}}








@extends('layouts.app')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-4">Products By Category</h2>

        <div class="card">
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-4">
                        <select class="form-select" onchange="window.location.href=this.value">
                            <option value="{{ route('products.by.category') }}" {{ !request()->route('category') ? 'selected' : '' }}>Select a category</option>
                            @foreach($categories as $cat)
                                <option value="{{ route('products.filter.by.category', $cat) }}" {{ request()->route('category')?->id === $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Supplier</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $product)
                                <tr>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->description }}</td>
                                    <td>{{ $product->price }}</td>
                                    <td>{{ $product->stock ?   $product->stock->quantity:0}}</td>
                                    <td>{{ $product->supplier->first_name}} {{ $product->supplier->last_name}}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No products found in this category</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>



    </div>
@endsection




