@extends('layouts.app')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-4">Products By Store</h2>

        <div class="card">
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <select id="store-select" class="form-select">
                            <option value="">Select a Store</option>
                            @foreach($stores as $store)
                                <option value="{{ $store->id }}">{{ $store->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div id="loading" class="d-none">
                    <div class="d-flex justify-content-center">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
                <div id="products-container">
                    <!-- Products will be loaded here via Axios -->
                </div>
            </div>
        </div>

    </div>


@push('scripts')
<script>
    document.getElementById('store-select').addEventListener('change', function() {
        const storeId = this.value;
        const loadingElement = document.getElementById('loading');
        const productsContainer = document.getElementById('products-container');
        productsContainer.innerHTML = '';
        if (storeId) {
            loadingElement.classList.remove('d-none');


            axios.get(`/api/products-store/${storeId}`)
                .then(response => {
                    const products = response.data;
                    let html = '<div class="table-responsive"><table class="table table-hover"><thead><tr>';
                    html += '<th>Name</th><th>Category</th><th>Description</th><th>Price</th><th>Stock</th></tr></thead><tbody>';

                    if (products.length > 0) {
                        products.forEach(product => {
                            html += `<tr>
                                <td>${product.name}</td>
                                <td>${product.category.name}</td>
                                <td>${product.description}</td>
                                <td>$${parseFloat(product.price).toFixed(2)}</td>
                                <td>${product.stock ? product.stock.quantity : 0}</td>
                            </tr>`;
                        });
                    } else {
                        html += '<tr><td colspan="5" class="text-center">No products found in this store</td></tr>';
                    }

                    html += '</tbody></table></div>';
                    productsContainer.innerHTML = html;
                })
                .catch(error => {
                    console.error('Error:', error);
                    productsContainer.innerHTML = '<div class="alert alert-danger">Error loading products</div>';
                })
                .finally(() => {
                    loadingElement.classList.add('d-none');
                });
        }
        else
        {
            productsContainer.innerHTML = 'there is no products for this store';
        }
    });
</script>
@endpush

@endsection




