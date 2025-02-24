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
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Thêm trong <head> để có CSRF token -->
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
            <!-- Style -->


<!-- Add this CSS in your existing style section -->
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

<div class="container d-flex flex-column min-vh-100 pt-6">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="card-title mb-0 fs-1">Menu List</h2>
                <a href="{{ route('admin.menus.create') }}" class="btn btn-success custom-btn-add">
                    <i data-feather="plus"></i>
                    <span>Add New Dish</span>
                </a>
            </div>

            <!-- Display Notification -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif




            <!-- Search Bar -->
<!-- Search Bar -->
<div class="row mb-4">
    <div class="col-md-6">
        <form action="{{ route('admin.menus') }}" method="GET" class="d-flex gap-2">
            <div class="input-group">
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}" 
                       class="form-control" 
                       placeholder="Search dishes by name...">
                <select name="category" class="form-select" style="max-width: 200px;">
                    <option value="">All Categories</option>
                    <option value="1" {{ request('category') == '1' ? 'selected' : '' }}>Main Dish</option>
                    <option value="2" {{ request('category') == '2' ? 'selected' : '' }}>Appetizer</option>
                    <option value="3" {{ request('category') == '3' ? 'selected' : '' }}>Dessert</option>
                    <option value="4" {{ request('category') == '4' ? 'selected' : '' }}>Beverage</option>
                </select>
                <button type="submit" class="btn btn-primary">
                    <i data-feather="search"></i> Search
                </button>
                @if(request('search') || request('category'))
                    <a href="{{ route('admin.menus') }}" class="btn btn-secondary">
                        <i data-feather="x"></i> Clear
                    </a>
                @endif
            </div>
        </form>
    </div>
</div>
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
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%236B7280'%3e%3cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3e%3c/path%3e%3c/svg%3e");
        background-position: right 0.75rem center;
        background-repeat: no-repeat;
        background-size: 1rem;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
    }
    
    .form-select:hover {
        border-color: #6571ff;
        
    }
    

    .input-group > .form-select {
        flex: 0 0 auto;
        width: auto;
        min-width: 160px;
    }
    
    /* Custom styling for options */
    .form-select option {
        padding: 0.5rem;
        font-weight: 500;
    }
    

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .form-select {
            font-size: 0.875rem;
            padding: 0.5rem 2rem 0.5rem 0.75rem;
        }
    }
    </style>

<!-- Add this style -->


            <!-- Table -->
            <div class="table-responsive ">
                <table class="table table-hover  ">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Dish Name</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Category</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($menus as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ Str::limit($item->description, 50) }}</td>
                                <td>{{ number_format($item->price, 0, ',', '.') }}đ</td>
                                <td>
                                    <span class="badge {{ $item->category == 1 ? 'bg-primary' : '' }}
                                                      {{ $item->category == 2 ? 'bg-success' : '' }}
                                                      {{ $item->category == 3 ? 'bg-warning' : '' }}
                                                      {{ $item->category == 4 ? 'bg-danger' : '' }}
                                                      {{ !in_array($item->category, [1,2,3,4]) ? 'bg-secondary' : '' }}">
                                        {{ $item->category == 1 ? 'Main Dish' : '' }}
                                        {{ $item->category == 2 ? 'Appetizer' : '' }}
                                        {{ $item->category == 3 ? 'Dessert' : '' }}
                                        {{ $item->category == 4 ? 'Beverage' : '' }}
                                        {{ !in_array($item->category, [1,2,3,4]) ? 'No Category' : '' }}
                                    </span>
                                </td>
                                
                                <td class="text-center">
                                    <a href="{{ route('admin.menus.edit', $item->id) }}" 
                                       class="btn btn-sm btn-outline-info me-2">
                                        <i data-feather="edit-2"></i>
                                    </a>
                                    <form action="{{ route('admin.menus.delete', $item->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-sm btn-outline-danger"
                                                onclick="confirmDelete(event, '{{ route('admin.menus.delete', $item->id) }}')">
                                            <i data-feather="trash-2"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No dishes found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>

            <!-- Pagination -->
        </div>
    </div>
</div>

<!-- Add this before closing body tag -->
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
    }, 4000);
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