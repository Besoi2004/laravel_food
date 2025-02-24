<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="description" content="Responsive HTML Admin Dashboard Template based on Bootstrap 5">
	<meta name="author" content="NobleUI">
	<meta name="keywords" content="nobleui, bootstrap, bootstrap 5, bootstrap5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

	<title>Admin Food</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
  <!-- End fonts -->

	<!-- core:css -->
	<link rel="stylesheet" href="{{ asset('backend/assets/vendors/core/core.css') }}">
	<!-- endinject -->

	<!-- Plugin css for this page -->
	<link rel="stylesheet" href="{{ asset('backend/assets/vendors/flatpickr/flatpickr.min.css') }}">
	<!-- End plugin css for this page -->

	<!-- inject:css -->
	<link rel="stylesheet" href="{{ asset('backend/assets/fonts/feather-font/css/iconfont.css') }}">
	<link rel="stylesheet" href="{{ asset('backend/assets/vendors/flag-icon-css/css/flag-icon.min.css') }}">
	<!-- endinject -->

  <!-- Layout styles -->  
	<link rel="stylesheet" href="{{ asset('backend/assets/css/demo2/style.css') }}">
  <!-- End layout styles -->

  <link rel="shortcut icon" href="{{ asset('backend/assets/images/favicon.png') }}" />
</head>

<body>
    <div class="main-wrapper">
        @include('admin.body.slidebar')
        <div class="page-wrapper">
            @include('admin.body.header')

            <div class="page-content">
                <div class="row">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-header">
                                <h1 class="text-center">Edit Order Detail</h1>
                            </div>
                            <div class="card-body">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form action="{{ route('admin.order-details.update', $orderDetail->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Order</label>
                                        <select name="order_id" class="form-control" required>
                                            <option value="">Select Order</option>
                                            @foreach($orders as $order)
                                                <option value="{{ $order->id }}" 
                                                    {{ $orderDetail->order_id == $order->id ? 'selected' : '' }}>
                                                    {{ $order->order_code }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Menu Item</label>
                                        <select name="menu_id" class="form-control" required>
                                            <option value="">Select Menu Item</option>
                                            @foreach($menus as $menu)
                                                <option value="{{ $menu->id }}" 
                                                        data-price="{{ $menu->price }}"
                                                        {{ $orderDetail->menu_id == $menu->id ? 'selected' : '' }}>
                                                    {{ $menu->name }} - {{ number_format($menu->price, 0, ',', '.') }}đ
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Quantity</label>
                                        <input type="number" 
                                               name="quantity" 
                                               class="form-control" 
                                               min="1" 
                                               value="{{ old('quantity', $orderDetail->quantity) }}" 
                                               required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Price</label>
                                        <input type="number" 
                                               name="price" 
                                               class="form-control" 
                                               step="0.01" 
                                               value="{{ old('price', $orderDetail->price) }}" 
                                               required 
                                               readonly>
                                    </div>

                                    <div class="text-center d-grid gap-2">
                                        <button type="submit" class="btn btn-outline-success">Update</button>
                                        <a href="{{ route('admin.order-details') }}" class="btn btn-outline-secondary">Cancel</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @include('admin.body.footer')
        </div>
    </div>

    <!-- ...existing scripts... -->

    <script>
        // Auto-update price when menu item changes
        document.querySelector('select[name="menu_id"]').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const price = selectedOption.dataset.price;
            document.querySelector('input[name="price"]').value = price;
        });
    </script>



	<!-- core:js -->
	<script src="{{ asset('backend/assets/vendors/core/core.js') }}"></script>
	<!-- endinject -->

	<!-- Plugin js for this page -->
  <script src="{{ asset('backend/assets/vendors/flatpickr/flatpickr.min.js') }}"></script>
  <script src="{{ asset('backend/assets/vendors/apexcharts/apexcharts.min.js') }}"></script>
	<!-- End plugin js for this page -->

	<!-- inject:js -->
	<script src="{{ asset('backend/assets/vendors/feather-icons/feather.min.js') }}"></script>
	<script src="{{ asset('backend/assets/js/template.js') }}"></script>
	<!-- endinject -->

	<!-- Custom js for this page -->
  <script src="{{ asset('backend/assets/js/dashboard-dark.js') }}"></script>
	<!-- End custom js for this page -->

</body>
</html>    