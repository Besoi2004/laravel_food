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
  <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Add this in the head section, after other CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<!-- Add this before closing body tag -->
<!-- Add this in head section if not already present -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Update the confirmDelete function -->
<script>
function confirmDelete(deleteUrl) {
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
            // Show success message first
            Swal.fire({
                title: "Deleted!",
                text: "Your file has been deleted.",
                icon: "success",
                timer: 1000,
                showConfirmButton: false
            });

            // Wait for 1 second before submitting the form
            setTimeout(() => {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = deleteUrl;

                // Add CSRF token
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = csrfToken;
                form.appendChild(csrfInput);

                // Add method spoofing
                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';
                form.appendChild(methodInput);

                // Append form to body and submit
                document.body.appendChild(form);
                form.submit();
            }, 1000); // Delay for 1 second to show the success message
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


</head>


<body>
    <div class="main-wrapper">
        @include('admin.body.slidebar')
        <div class="page-wrapper">
            @include('admin.body.header')

            <!-- Main content -->
<!-- ...existing head and body opening... -->

<div class="page-content ">
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="card-title mb-0 fs-1">Orders Detail</h2>
                        <a href="{{ route('admin.order-details.create') }}" class="btn btn-success custom-btn-add">
                            <i data-feather="plus"></i>
                            <span>New Order Detail</span>
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
                            <form action="{{ route('admin.order-details') }}" method="GET" class="d-flex gap-2">
                                <div class="input-group">
                                    <input type="text" 
                                           name="search" 
                                           value="{{ request('search') }}" 
                                           class="form-control" 
                                           placeholder="Search by menu name or order code...">
                                    <button type="submit" class="btn btn-primary">
                                        <i data-feather="search"></i> Search
                                    </button>
                                    @if(request('search'))
                                        <a href="{{ route('admin.order-details') }}" class="btn btn-secondary">
                                            <i data-feather="x"></i> Clear
                                        </a>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>  
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
<!-- ...existing footer and scripts... -->
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>ID</th>
                                                <th>Order Code</th>
                                                <th>Item Name</th>
                                                <th>Quantity</th>
                                                <th>Price</th>
                                                <th>Total</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($orderDetails as $key => $detail)
                                                <tr>
                                                    <td>{{  $key +1 }}</td>
                                                    <td>{{ $detail->order->order_code }}</td>
                                                    <td>{{ $detail->menu->name }}</td>
                                                    <td>{{ $detail->quantity }}</td>
                                                    <td>{{ number_format($detail->price, 0, ',', '.') }}đ</td>
                                                    <td>{{ number_format($detail->price * $detail->quantity, 0, ',', '.') }}đ</td>
                                                    <td>
                                                        <a href="{{ route('admin.order-details.edit', $detail->id) }}" 
                                                            class="btn btn-sm btn-outline-info me-2">
                                                             <i data-feather="edit-2"></i>
                                                         </a>
                                                         <form action="{{ route('admin.order-details.destroy', $detail->id) }}" 
                                                            method="POST" 
                                                            class="d-inline">
                                                          @csrf
                                                          @method('DELETE')
                                                          <button type="button" 
                                                                class="btn btn-sm btn-outline-danger"
                                                                onclick="confirmDelete('{{ route('admin.order-details.destroy', $detail->id) }}')">
                                                                <i data-feather="trash-2"></i>
                                                            </button>
                                                           
                                                          
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
                </div>
            </div>
            <!-- End main content -->

            @include('admin.body.footer')
        </div>
    </div>
    <!-- ...existing scripts... -->

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
  <script src="{{ asset('backend/assets/js/dashboard-dark.js') }}"></script>>
</body>
</html>