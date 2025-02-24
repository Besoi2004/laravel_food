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

		<!-- partial:partials/_sidebar.html -->
    @include('admin.body.slidebar')

		<!-- partial -->
	
		<div class="page-wrapper">
					
			<!-- partial:partials/_navbar.html -->
    @include('admin.body.header')
			<!-- partial -->
            <div class="container d-flex flex-column min-vh-100 pt-6">
                <div class="card shadow-lg p-4 rounded">
                    <h2 class="text-center pt-4">Edit Dish</h2>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('admin.menus.update', $menu->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Dish Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $menu->name) }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="3">{{ old('description', $menu->description) }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Price</label>
                            <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price', $menu->price) }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <select name="category" class="form-control" required>
                                <option value="1" {{ $menu->category == 1 ? 'selected' : '' }}>Main Dish</option>
                                <option value="2" {{ $menu->category == 2 ? 'selected' : '' }}>Appetizer</option>
                                <option value="3" {{ $menu->category == 3 ? 'selected' : '' }}>Dessert</option>
                                <option value="4" {{ $menu->category == 4 ? 'selected' : '' }}>Beverage</option>
                            </select>
                        </div>
                        <div class="text-center d-grid gap-2">
                            <button type="submit" class="btn btn-outline-success">Update</button>
                            <a href="{{ route('admin.menus') }}" class="btn btn-outline-secondary">Cancel</a>
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