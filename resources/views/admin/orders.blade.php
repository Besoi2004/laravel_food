<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Orders</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    
    <!-- core:css -->
    <link rel="stylesheet" href="{{ asset('backend/assets/vendors/core/core.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/demo2/style.css') }}">
    <link rel="shortcut icon" href="{{ asset('backend/assets/images/favicon.png') }}" />
    <!-- Add this in the head section -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Add this before closing </body> tag -->
 <meta name="csrf-token" content="{{ csrf_token() }}">

 <script>
    function confirmDelete(event, formAction) {
        event.preventDefault();
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                // Hiển thị thông báo trước khi xóa
                Swal.fire({
                    title: "Deleted!",
                    text: "Your file has been deleted.",
                    icon: "success",
                    timer: 1000, // Hiển thị 4 giây
                    showConfirmButton: false
                });

                setTimeout(() => {
                    let form = document.createElement('form');
                    form.action = formAction;
                    form.method = 'POST';

                    let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                    let csrf = document.createElement('input');
                    csrf.type = 'hidden';
                    csrf.name = '_token';
                    csrf.value = csrfToken;

                    let method = document.createElement('input');
                    method.type = 'hidden';
                    method.name = '_method';
                    method.value = 'DELETE';

                    form.appendChild(csrf);
                    form.appendChild(method);
                    document.body.appendChild(form);
                    form.submit();
                }, 4000); // Chờ 4 giây trước khi gửi yêu cầu xóa
            }
        });
    }
</script>
<style>
    .custom-btn-add {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        border: none;
        padding: 0.6rem 1.2rem;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        color: white;
        font-weight: 500;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(40, 167, 69, 0.2);
    }
    
    .custom-btn-add:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(40, 167, 69, 0.3);
        background: linear-gradient(135deg, #218838 0%, #1ba97e 100%);
    }
    
    .custom-btn-add:active {
        transform: translateY(0);
        box-shadow: 0 2px 10px rgba(40, 167, 69, 0.2);
    }
    
    .custom-btn-add i {
        width: 18px;
        height: 18px;
        stroke-width: 2.5;
        transition: transform 0.3s ease;
    }
    
    .custom-btn-add:hover i {
        transform: rotate(90deg);
    }
    
    @media (max-width: 768px) {
        .custom-btn-add {
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
        }
    }
    </style>
    <style>
        .form-select {
            padding: 0.625rem 2.25rem 0.625rem 1rem;
            background-color: #6571ff;
            border: 1px solid #6571ff;
            border-radius: 0.375rem;
            font-size: 0.95rem;
            font-weight: 500;
            color: #ffffff;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .form-select:hover {
            border-color: #6571ff;
        }
        
        .form-select:focus {
            border-color: #6571ff;
            outline: 0;
            box-shadow: 0 0 0 0.2rem rgba(101, 113, 255, 0.25);
        }
        
        .input-group > .form-select {
            flex: 0 0 auto;
            width: auto;
        }
        </style>
</head>
<body>
    <div class="main-wrapper">
        @include('admin.body.slidebar')
        <div class="page-wrapper">
            @include('admin.body.header')

            <div class="container d-flex flex-column min-vh-100 pt-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h2 class="card-title mb-0 fs-1">Orders List</h2>
                            <a href="{{ route('admin.orders.create') }}" class="btn btn-success custom-btn-add">
                                <i data-feather="plus"></i>
                                <span>Add New Order</span>
                            </a>
                        </div>

                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <form action="{{ route('admin.orders') }}" method="GET" class="d-flex gap-2">
                                    <div class="input-group">
                                        <input type="text" 
                                               name="search" 
                                               value="{{ request('search') }}" 
                                               class="form-control" 
                                               placeholder="Search by order code or customer...">
                                        <select name="status" class="form-select" style="max-width: 200px;">
                                            <option value="">All Status</option>
                                            <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Pending</option>
                                            <option value="2" {{ request('status') == '2' ? 'selected' : '' }}>Completed</option>
                                            <option value="3" {{ request('status') == '3' ? 'selected' : '' }}>Cancelled</option>
                                        </select>
                                        <button type="submit" class="btn btn-primary">
                                            <i data-feather="search"></i> Search
                                        </button>
                                        @if(request('search') || request('status'))
                                            <a href="{{ route('admin.orders') }}" class="btn btn-secondary">
                                                <i data-feather="x"></i> Clear
                                            </a>
                                        @endif
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Order Code</th>
                                        <th>Customer</th>
                                        <th>Total Price</th>
                                        <th>Status</th>
                                        <th>Created At</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($orders as $key => $order)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $order->order_code }}</td>
                                            <td>{{ $order->customer_name }}</td>
                                            <td>{{ number_format($order->total_price, 0, ',', '.') }}đ</td>
                                            <td>
                                                @php
                                                    $statusMapping = [
                                                        1 => 'Pending',
                                                        2 => 'Completed',
                                                        3 => 'Cancelled',
                                                    ];
                                                    $statusClass = [
                                                        1 => 'bg-warning',
                                                        2 => 'bg-success',
                                                        3 => 'bg-danger',
                                                    ];
                                                    $statusText = $statusMapping[$order->status] ?? 'Unknown';
                                                    $statusBadge = $statusClass[$order->status] ?? 'bg-secondary';
                                                @endphp
                                                <span class="badge {{ $statusBadge }}">{{ $statusText }}</span>
                                            </td>
                                            
                                            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                            <td class="text-center">
                                                <!-- View Details Button -->
                                                <a href="{{ route('admin.orders.details', $order->id) }}" 
                                                   class="btn btn-sm btn-outline-primary me-2">
                                                    <i data-feather="eye"></i>
                                                </a>
                                                
                                                <!-- Edit Button -->
                                                <a href="{{ route('admin.orders.edit', $order->id) }}" 
                                                   class="btn btn-sm btn-outline-info me-2">
                                                    <i data-feather="edit-2"></i>
                                                </a>
                                                
                                                <!-- Delete Form -->
                                                <form action="{{ route('admin.orders.destroy', $order->id) }}" 
                                                      method="POST" 
                                                      class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" 
                                                            class="btn btn-sm btn-outline-danger"
                                                            onclick="confirmDelete(event, '{{ route('admin.orders.destroy', $order->id) }}')">
                                                        <i data-feather="trash-2"></i>
                                                    </button>
                                                </form>
                                            </td>
                                           <!-- filepath: /c:/Code/PHP/laravel_food/resources/views/admin/orders.blade.php -->
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">No orders found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


            <script>
                // Initialize Feather Icons
                document.addEventListener('DOMContentLoaded', function() {
                    feather.replace();
                });
            
                // Auto-hide alerts after 3 seconds
                window.setTimeout(function() {
                    $('.alert').fadeTo(500, 0).slideUp(500, function(){
                        $(this).remove(); 
                    });
                }, 5000);
            </script>
            <style>
    
                .btn {
                    display: inline-flex;
                    align-items: center;
                    gap: 0.5rem;
                }
                
                .table td {
                    vertical-align: middle;
                }
            
                .badge {
                    font-size: 0.85rem;
                    padding: 0.5em 1em;
                }
            
                .alert {
                    margin-bottom: 1.5rem;
                }
            </style>           

            @include('admin.body.footer')
        </div>
    </div>

    <script src="{{ asset('backend/assets/vendors/core/core.js') }}"></script>
    <script src="{{ asset('backend/assets/vendors/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/template.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            feather.replace();
        }); 

        window.setTimeout(function() {
            $('.alert').fadeTo(500, 0).slideUp(500, function(){
                $(this).remove(); 
            });
        }, 3000);
    </script>
</body>
</html>
