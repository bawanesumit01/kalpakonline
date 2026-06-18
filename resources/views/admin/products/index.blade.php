@extends('layouts.app')

@section('content')
    <div class="page-wrapper mdc-toolbar-fixed-adjust">
        <main class="content-wrapper">
            <div class="mdc-layout-grid">
                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
                    <div class="mdc-card p-0">
                        <!-- Breadcrumbs -->
                        <div class="row mx-4">
                            <div class="col-5 align-self-center">
                                <h4 class="mdc-typography--headline4 pt-2">Dashboard</h4>
                                <div class="d-flex align-items-center">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item">
                                                <a href="#" class="text-decoration-none">Home</a>
                                            </li>
                                            <li class="breadcrumb-item mdc-typography--subtitle1 active"
                                                aria-current="page">
                                                Products
                                            </li>
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                            <div class="col-7 align-self-center">
                                <div class="d-flex no-block justify-content-end align-items-center">
                                    <a href="{{ route('products.create') }}">
                                        <button
                                            class="mdc-typography--button mdc-button mdc-button--raised mdc-button--dense mdc-ripple-upgraded"
                                            style="--mdc-ripple-fg-size: 44px; --mdc-ripple-fg-scale: 2.0637770928470114; --mdc-ripple-fg-translate-start: 12.137451171875px, 0.1999969482421875px; --mdc-ripple-fg-translate-end: 15.10000228881836px, -6px;">
                                            <i class="fa-solid fa-plus pe-1"></i>Create Product
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive shadow p-2">


                            <table id="all-table-common" class="table table-striped p-2">
                                <thead>
                                    <tr>
                                        <th class="text-left">Id</th>
                                        <th>Product</th>
                                        <th>SKU</th>
                                        @if (auth()->user()->role === 'superadmin')
                                            <th>Vendor</th>
                                        @endif
                                        <th>Category</th>
                                        <th>Cost</th>
                                        <th>Selling</th>
                                        <th>Discount(%)</th>
                                        <th>Final Price</th>
                                        {{-- <th>Tax Rate</th> --}}
                                        <th>Stock</th>
                                        <th> Min Stock Alert</th>
                                        <th>Stock Status </th>
                                        <th>Image </th>
                                        <th> Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $product)
                                        <tr>
                                            <td class="text-left">{{ $product->id }}</td>
                                            <td class="text-left">{{ $product->product_name }}</td>
                                            <td class="text-left">{{ $product->product_sku }}</td>
                                            @if (auth()->user()->role === 'superadmin')
                                                <td class="text-left">{{ $product->vendor->vendor_name ?? null }}</td>
                                            @endif
                                            <td class="text-left">{{ $product->category->category_name ?? null }}</td>
                                            <td class="text-left">{{ $product->cost_price }}</td>
                                            <td class="text-left">{{ $product->selling_price }}</td>
                                            <td class="text-left">{{ $product->discount_percent }}</td>
                                            <td class="text-left">{{ $product->final_price }}</td>
                                            <td class="text-left">{{ $product->stock_quantity }}</td>
                                            <td class="text-left">{{ $product->min_stock_alert }}</td>
                                            <td class="text-left">{{ $product->stock_status }}</td>
                                            <td class="text-left"><a href="{{ asset('/' . $product->main_image) }}" target="_blank">
                                                <img src="{{ asset('/' . $product->main_image) }}"
                                                    alt="Product Image" width="50"></a></td>
                                            <td class="text-left">{{ $product->status }}</td>
                                            <td>
                                                <a href="{{ route('products.edit', $product->id) }}"
                                                    class="btn btn-sm btn-primary">Edit</a>
                                                <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Are you sure?')">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>


                    </div>
                </div>
            </div>
        </main>
    </div>
@endsection
