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
                                                Category
                                            </li>
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                            <div class="col-7 align-self-center">
                                <div class="d-flex no-block justify-content-end align-items-center">
                                    <a href="{{ route('category.create') }}">
                                        <button
                                            class="mdc-typography--button mdc-button mdc-button--raised mdc-button--dense mdc-ripple-upgraded"
                                            style="--mdc-ripple-fg-size: 44px; --mdc-ripple-fg-scale: 2.0637770928470114; --mdc-ripple-fg-translate-start: 12.137451171875px, 0.1999969482421875px; --mdc-ripple-fg-translate-end: 15.10000228881836px, -6px;">
                                            <i class="fa-solid fa-plus pe-1"></i>Create Category
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive shadow p-2">


                            <table id="all-table-common" class="table table-striped p-2">
                                <thead>
                                    <tr>
                                        <th class="text-left">Category Id</th>
                                        <th>Category Name</th>
                                        @if (auth()->user()->role === 'superadmin')
                                            <th>Vendor</th>
                                        @endif
                                        <th>Image</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categories as $category)
                                        <tr>
                                            <td class="text-left">{{ $category->category_id }}</td>
                                            <td class="text-left">{{ $category->category_name }}</td>
                                            @if (auth()->user()->role === 'superadmin')
                                                <td class="text-left">{{ $category->vendor->vendor_name ?? null }}</td>
                                            @endif
                                            <td class="text-left"><a href="{{ asset('/categoryImage/' . $category->cat_image) }}" target="_blank"><img src="{{ asset('/categoryImage/' . $category->cat_image) }}"
                                                    alt="Category Image" width="50"></a></td>
                                            <td class="text-left">
                                                <a href="{{ route('category.edit', $category->category_id) }}"
                                                    class="btn btn-sm btn-primary">Edit</a>
                                                <form action="{{ route('category.destroy', $category->category_id) }}"
                                                    method="POST" class="d-inline">
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
