<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Order</title>
    
    <link rel="stylesheet" href="{{ asset('backend/assets/vendors/core/core.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/demo2/style.css') }}">
</head>
<body>
    <div class="main-wrapper">
        @include('admin.body.slidebar')
        <div class="page-wrapper">
            @include('admin.body.header')
            <div class="container pt-6">
                <div class="card shadow-lg p-4 rounded">
                    <h2 class="text-center">Edit Order</h2>
                    
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
    
                    <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Custom Order Number (1-999)</label>
                            <input type="number" 
                                   name="custom_order_number" 
                                   class="form-control" 
                                   value="{{ old('custom_order_number', substr($order->order_code, -3)) }}" 
                                   min="1" 
                                   max="999" 
                                   required>
                            <small class="text-muted">Enter a number between 1 and 999. This will be used to generate the order code.</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Customer Name</label>
                            <input type="text" name="customer_name" class="form-control" value="{{ old('customer_name', $order->customer_name) }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Total Price</label>
                            <input type="number" step="0.01" name="total_price" class="form-control" value="{{ old('total_price', $order->total_price) }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-control" required>
                                <option value="1" {{ old('status', $order->status) == 1 ? 'selected' : '' }}>Pending</option>
                                <option value="2" {{ old('status', $order->status) == 2 ? 'selected' : '' }}>Completed</option>
                                <option value="3" {{ old('status', $order->status) == 3 ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                        <div class="text-center d-grid gap-2">
                            <button type="submit" class="btn btn-outline-primary">Update</button>
                            <a href="{{ route('admin.orders') }}" class="btn btn-outline-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
            @include('admin.body.footer')
        </div>
    </div>

    <script src="{{ asset('backend/assets/vendors/core/core.js') }}"></script>
    <script src="{{ asset('backend/assets/vendors/feather-icons/feather.min.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            feather.replace();
        });
    </script>
</body>
</html>
