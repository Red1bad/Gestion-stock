@extends('layouts.app')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-4">Products By Supplier</h2>

        <div class="card">
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-4">
                        <select class="form-select" id="supplier-select" >
                            <option value="">Select a supplier</option>
                            @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}">
                                {{ $supplier->first_name }} {{ $supplier->last_name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div id="loading" class="text-center d-none">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
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
        document.getElementById('supplier-select').addEventListener('change', function() {
            const supplierId = this.value;

            const loadingElement = document.getElementById('loading');
            const productsContainer = document.getElementById('products-container');
            productsContainer.innerHTML = '';
            if (supplierId) {
                loadingElement.classList.remove('d-none');

                axios.get(`/api/products-by-supplier/${supplierId}`)
                    .then(response => {
                        productsContainer.innerHTML = response.data;
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    })
                    .finally(() => {
                        loadingElement.classList.add('d-none');
                    });
            }
        });
    </script>
    @endpush


@endsection




