<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="description" content="Responsive HTML Admin Dashboard Template based on Bootstrap 5">
	<meta name="author" content="NobleUI">
	<meta name="keywords" content="nobleui, bootstrap, bootstrap 5, bootstrap5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

	<title>Admin Orders</title>

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

		<!-- partial:partials/_sidebar.html -->
    @include('admin.body.slidebar')

		<!-- partial -->
	
		<div class="page-wrapper">
					
			<!-- partial:partials/_navbar.html -->
    @include('admin.body.header')
			<!-- partial -->
      <div class="container d-flex flex-column min-vh-100 pt-6">
        <div class="card shadow-lg p-4 rounded">
            <h2 class="text-center pt-4">Add New Order</h2>
            
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
    
            <form action="{{ route('admin.orders.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                  <label class="form-label">Custom Order Number (1-999)</label>
                  <input type="number" 
                         name="custom_order_number" 
                         class="form-control" 
                         min="1" 
                         max="999" 
                         value="{{ old('custom_order_number') }}" 
                         required>
                  <small class="text-muted">Enter a number between 1 and 999. This will be used to generate the order code.</small>
              </div>
                
                <div class="mb-3">
                    <label class="form-label">Customer Name</label>
                    <input type="text" name="customer_name" class="form-control" value="{{ old('customer_name') }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Total Price</label>
                    <input type="number" step="0.01" name="total_price" class="form-control" value="{{ old('total_price') }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control" required>
                        <option value="1">Pending</option>
                        <option value="2">Completed</option>
                        <option value="3">Cancelled</option>
                    </select>
                </div>
                <div class="text-center d-grid gap-2">
                    <button type="submit" class="btn btn-outline-primary">Add</button>
                    <a href="{{ route('admin.orders') }}" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
    
    

			<!-- partial:partials/_footer.html -->
    @include('admin.body.footer')
			<!-- partial -->
	
		</div>
	</div>

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
