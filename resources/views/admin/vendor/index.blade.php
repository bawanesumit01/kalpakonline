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
                                                Vendor
                                            </li>
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                            <div class="col-7 align-self-center">
                                <div class="d-flex no-block justify-content-end align-items-center">
                                    <a href="{{ route('vendor.create') }}">
                                        <button
                                            class="mdc-typography--button mdc-button mdc-button--raised mdc-button--dense mdc-ripple-upgraded"
                                            style="--mdc-ripple-fg-size: 44px; --mdc-ripple-fg-scale: 2.0637770928470114; --mdc-ripple-fg-translate-start: 12.137451171875px, 0.1999969482421875px; --mdc-ripple-fg-translate-end: 15.10000228881836px, -6px;">
                                            <i class="fa-solid fa-plus pe-1"></i>Create Vendor
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive shadow p-2">
                           

                            <table id="all-table-common" class="table table-striped p-2">
                                <thead>
                                    <tr>
                                        <th class="text-left">Vendor Name</th>
                                        <th>User Name</th>
                                        <th>User Email</th>
                                        <th>Mobile Number</th>
                                        <th>User Role</th>
                                        <th>User Permissions</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($vendors as $vendor)
                                        <tr>
                                            <td class="text-left">{{ $vendor->vendor_name }}</td>
                                            <td class="text-left">{{ $vendor->user->name }}</td>
                                            <td class="text-left">{{ $vendor->user->email }}</td>
                                            <td class="text-left">{{ $vendor->user->mobile }}</td>
                                            <td class="text-left">{{ $vendor->user->role }}</td>
                                            <td class="text-left"> {{ implode(', ', $vendor->user->permissions ?? []) }}</td>
                                            <td class="text-left">
                                                <a href="{{ route('vendor.edit', $vendor->vendor_id) }}"
                                                    class="btn btn-sm btn-primary">Edit</a>
                                                <form action="{{ route('vendor.destroy', $vendor->vendor_id) }}"
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
