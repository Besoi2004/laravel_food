<nav class="sidebar">
  <div class="sidebar-header">
      <a href="#" class="sidebar-brand fs-5">
          BE_SOi<span> RESTAURANT</span>
      </a>
      <div class="sidebar-toggler not-active">
          <span></span>
          <span></span>
          <span></span>
      </div>
  </div>
  <div class="sidebar-body d-flex flex-column">
      <ul class="nav flex-grow-1">
          <li class="nav-item nav-category">Main</li>
          <li class="nav-item">
              <a href="{{ route('admin.dashboard') }}" class="nav-link">
                  <i class="link-icon" data-feather="box"></i>
                  <span class="link-title fs-3">Dashboard</span>
              </a>
          </li>
          <li class="nav-item">
              <a href="{{ route('admin.menus') }}" class="nav-link">
                  <i class="link-icon" data-feather="book"></i>
                  <span class="link-title fs-3">Menu</span>
              </a>
          </li>
          <li class="nav-item">
              <a href="{{ route('admin.orders') }}" class="nav-link">
                  <i class="link-icon" data-feather="package"></i>
                  <span class="link-title fs-3">Order</span>
              </a>
          </li>
          <li class="nav-item">
              <a href="{{ route('admin.order-details') }}" class="nav-link">
                  <i class="link-icon" data-feather="file-text"></i>
                  <span class="link-title fs-3">Order Detail</span>
              </a>
          </li>
      </ul>
      
      <!-- Settings at bottom -->
      <ul class="nav  mt-auto pt-3">
          
          <li class="nav-item">
              <a href="" class="nav-link">
                  <i class="link-icon" data-feather="settings"></i>
                  <span class="link-title fs-3">Settings</span>
              </a>
          </li>
      </ul>
  </div>
</nav>