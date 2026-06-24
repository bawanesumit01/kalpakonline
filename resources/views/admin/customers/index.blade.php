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
                                        <li class="breadcrumb-item mdc-typography--subtitle1 active" aria-current="page">
                                            Customers
                                        </li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                        <div class="col-7 align-self-center">
                            <div class="d-flex no-block justify-content-end align-items-center gap-2">
                               
                                <a href="{{ route('admin.customers.export') }}">
                                    <button class="mdc-typography--button mdc-button mdc-button--raised mdc-button--dense mdc-ripple-upgraded">
                                        <i class="fa-solid fa-download pe-1"></i>Export CSV
                                    </button>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Search & Filter -->
                    <div class="p-4">
                        <form method="GET" class="row">
                            <div class="col-md-3">
                                <label class="form-label">Search Name/Email/Phone</label>
                                <input type="text" name="search" placeholder="Search..." 
                                       value="{{ request('search') }}" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Sort By</label>
                                <select name="sort_by" class="form-control">
                                    <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Latest Joined</option>
                                    <option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>Name</option>
                                    <option value="orders_count" {{ request('sort_by') == 'orders_count' ? 'selected' : '' }}>Orders Count</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Sort Order</label>
                                <select name="sort_order" class="form-control">
                                    <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>Descending</option>
                                    <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>Ascending</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">&nbsp;</label>
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fa-solid fa-search pe-1"></i>Search
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Customers Table -->
                    <div class="table-responsive shadow p-2">
                        <table id="all-table-common" class="table table-striped p-2">
                            <thead>
                                <tr>
                                    <th class="text-left">Customer Name</th>
                                    <th class="text-left">Email</th>
                                    <th class="text-left">Phone</th>
                                    <th class="text-left">Orders</th>
                                    <th class="text-left">Total Spent</th>
                                    <th class="text-left">Joined</th>
                                    <th class="text-left">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($customers as $customer)
                                <tr>
                                    <td class="text-left">
                                        <a href="{{ route('admin.customers.show', $customer->id) }}" class="text-primary">
                                            {{ $customer->name }}
                                        </a>
                                    </td>
                                    <td class="text-left">{{ $customer->email }}</td>
                                    <td class="text-left">{{ $customer->mobile }}</td>
                                    <td class="text-left">
                                        <span class="badge bg-info">{{ $customer->orders_count }}</span>
                                    </td>
                                    <td class="text-left">
                                        <strong>₹{{ number_format($customer->orders_sum_total ?? 0, 2) }}</strong>
                                    </td>
                                    <td class="text-left">{{ $customer->created_at->format('M d, Y') }}</td>
                                    <td class="text-left">
                                        <a href="{{ route('admin.customers.show', $customer->id) }}" class="btn btn-sm btn-primary">View</a>
                                        <a href="{{ route('admin.customers.edit', $customer->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                        <a href="{{ route('admin.customers.orders', $customer->id) }}" class="btn btn-sm btn-info">Orders</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">No customers found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($customers->hasPages())
                    <div class="p-4">
                        {{ $customers->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </main>
</div>
@endsection
