@extends('layouts.app')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <!-- Total Courses Card -->
        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Customers</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $totalCustomers }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Students Card -->
        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Suppliers</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $totalSuppliers }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>


        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-red-500 rounded-md p-3">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Products</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $totalProducts }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-center gap-3">
        <a href="/customers" class="btn btn-primary btn-lg shadow-sm">List of Customers</a>
        <a href="/suppliers" class="btn btn-success btn-lg shadow-sm">List of Suppliers</a>
        <a href="/products" class="btn btn-info btn-lg shadow-sm">List of Products</a>
        <a href="/products-by-category" class="btn btn-warning btn-lg shadow-sm">Products by Category</a>
        <a href="/products-by-supplier" class="btn btn-secondary btn-lg shadow-sm">Products by Supplier</a>
        <a href="/products-by-store" class="btn btn-dark btn-lg shadow-sm">Products by Store</a>
        <a href="{{ route('orders.index') }}" class="btn btn-danger btn-lg shadow-sm">Orders by Customer</a>
    </div>

    <br><br><br>

    <main class="container bg-white flex-grow-1 text-center py-4">

        <div class="justify-content-center gap-3">
            <div>
                <h1>
                    Hello
                    @if(Cookie::has("UserName"))
                            {{Cookie::get("UserName")}}
                    @endif
                </h1>
            </div>
            <div>
                <form method="POST" action="saveCookie">
                    @csrf
                    <label for="txtCookie">{{__('Type your name')}}</label>
                    <input type="text" id = "txtCookie" name = "txtCookie" />
                    <button class="btn btn-primary bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        {{__('Save Cookie') }}
                    </button>
                </form>
            </div>
        </div>

        <br><br>
        <hr>
        <br><br>

        <div>
            <div>
                <h1>
                    Hello
                    @if(Session::has("SessionName"))
                            {{Session("SessionName")}}
                    @endif
                </h1>
            </div>
            <div>
                <form method="POST" action="saveSession">
                    @csrf
                    <label for="txtSession">{{__('Type your name')}}</label>
                    <input type="text" id = "txSession" name = "txtSession" />
                    <button class="btn btn-primary bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        {{__('Save Session') }}
                    </button>
                </form>
            </div>
        </div>

        <br><br>
        <hr>
        <br><br>

        <div>
            <form method="POST" action="saveAvatar"  enctype="multipart/form-data" >
                @csrf
                <label for="avatarFile">@lang('Choose your picture')</label>
                <input type="file" id = "avatarFile"  name = "avatarFile" />
                <button class="btn btn-primary bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    {{__('Save picture') }} {{ trans("for your account") }}
                </button>
                {{--  il faut executer php artisan storage:link pour assosier le racourcis storage --}}
                <img style = "width:200px; border-radius:50%" src="{{"storage/avatars/".$pic}}" alt="">
            </form>
        </div>


    </main>

@endsection
