# Hệ Thống Quản Lý Nhà Hàng

## Giới thiệu
Hệ thống quản lý nhà hàng được xây dựng bằng Laravel Framework, cung cấp giải pháp toàn diện cho việc quản lý menu, đơn hàng và báo cáo.

## Tính năng chính

### 1. Dashboard Admin
- Thống kê doanh thu
- Báo cáo đơn hàng
- Quản lý người dùng

### 2. Quản lý Menu (Menu)
- Thêm, sửa, xóa món ăn
- Phân loại theo danh mục:
  - Món chính (Main Dish)
  - Món khai vị (Appetizer)
  - Món tráng miệng (Dessert)
  - Đồ uống (Beverage)
- Tìm kiếm món ăn nâng cao
- Quản lý giá và mô tả

### 3. Quản lý Đơn Hàng (Order)
- Theo dõi đơn hàng theo thời gian thực
- Thêm, sửa, xóa đơn hàng
- Xử lý đơn hàng:
  - Đang chờ xử lý (Pending)
  - Hoàn thành (Completed)
  - Hủy (Cancelled)
- Lịch sử đơn hàng

### 4. Quản lý Chi tiết Đơn Hàng (Order Detail)
- Thêm, sửa, xóa chi tiết đơn hàng
- Tidm kiếm

### 5. Bảo Mật
- Hệ thống đăng nhập an toàn
- Phân quyền admin
- Bảo vệ thông tin khách hàng

## Sơ đồ chức năng
![image](https://github.com/user-attachments/assets/a4ad0d98-6392-4f60-89ad-bb37dcfc6699)


## Công nghệ sử dụng
- Laravel 9.x
- MySQL
- Bootstrap 5
- JavaScript/jQuery
- AJAX
- SweetAlert2

## Cấu trúc thư mục chính
```
laravel_food/
├── app/
│   ├── Http/Controllers/
│   │   ├── AdminController.php
│   │   ├── MenuController.php
│   │   ├── OrderController.php
│   │   └── OrderDetailController.php
│   └── Models/
├── resources/
│   └── views/
│       └── admin/
└── public/
    └── backend/
```

## Nhóm phát triển
- Quản lý dự án: [Quản lý nhà hàng]
- Developer: [Nguyễn Huy Tấn]

## Liên hệ
- Email: [22010078@st.phenikaa-uni.edu.vn]

