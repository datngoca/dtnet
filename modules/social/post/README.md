# Module Post

Module quản lý bài viết với các tính năng đầy đủ.

## Cấu trúc Module

### Các trường dữ liệu chính:

- **type**: Loại bài viết (news, event, blog, review, announcement)
- **category**: Danh mục (general, business, technology, entertainment, sports, education)
- **title**: Tiêu đề bài viết
- **des**: Mô tả ngắn
- **content**: Nội dung chi tiết
- **address**: Địa điểm (chọn từ danh sách place)

### Cấu trúc thư mục:

```
modules/social/post/
├── post_dev.php                    # Controller chính
├── index/                          # Phần quản lý cá nhân
│   ├── index_post_dev.php         # Trang chính
│   ├── input_post_dev.php         # Form nhập/sửa
│   ├── list_post_dev.php          # Danh sách bài viết
│   ├── info_post_dev.php          # Thông tin chi tiết
│   ├── save_post_dev.php          # Lưu dữ liệu
│   ├── get_area_post_dev.php      # Lấy danh sách khu vực
│   ├── get_place_post_dev.php     # Lấy danh sách địa điểm
│   ├── js_index_post_dev.php      # JavaScript cho trang chính
│   └── js_input_post_dev.php      # JavaScript cho form nhập
├── user/                           # Phần quản lý user
│   └── user_post_dev.php          # Trang quản lý user posts
└── all/                           # Phần quản lý toàn bộ
    └── all_post_dev.php          # Trang quản lý tất cả posts

modules/dtnet/api/
├── post_api_dev.php               # API controller chính
└── post/                          # API endpoints
    ├── save_my_post_api_dev.php   # Lưu bài viết
    ├── list_my_post_api_dev.php   # Danh sách bài viết cá nhân
    ├── info_my_post_api_dev.php   # Thông tin bài viết
    └── delete_my_post_api_dev.php # Xóa bài viết
```

## Tính năng

### 1. Quản lý cá nhân (index)

- Tạo bài viết mới
- Chỉnh sửa bài viết
- Xem danh sách bài viết của mình
- Xóa bài viết
- Tìm kiếm bài viết
- Lọc theo type, category, area, place

### 2. Quản lý user (user)

- Xem danh sách bài viết của các user
- Duyệt bài viết
- Quản lý trạng thái bài viết

### 3. Quản lý toàn bộ (all)

- Xem tất cả bài viết trong hệ thống
- Kích hoạt/tắt bài viết
- Quản lý trạng thái phê duyệt

## Cách sử dụng

### 1. Truy cập module

```
/post (trang chính)
/post/user (quản lý user posts)
/post/all (quản lý tất cả posts)
```

### 2. API endpoints

```php
// Lưu bài viết
$this->request_api("post", "save_my", $data);

// Lấy danh sách bài viết
$this->request_api("post", "list_my", $params);

// Lấy thông tin bài viết
$this->request_api("post", "info_my", ["post" => $uid_post]);

// Xóa bài viết
$this->request_api("post", "delete_my", ["post" => $uid_post]);
```

### 3. Tham số cho API

#### save_my:

- lang: Ngôn ngữ
- area_str_code: Mã khu vực
- uid_place: ID địa điểm
- type: Loại bài viết
- category: Danh mục
- title: Tiêu đề
- des: Mô tả
- content: Nội dung

#### list_my:

- lang: Ngôn ngữ (tùy chọn)
- area: Mã khu vực (tùy chọn)
- place: ID địa điểm (tùy chọn)
- type: Loại bài viết (tùy chọn)
- category: Danh mục (tùy chọn)
- search: Từ khóa tìm kiếm (tùy chọn)

## Database

Module này yêu cầu bảng `user_post` với các trường:

- uid: ID duy nhất
- uid_user: ID người dùng
- lang: Ngôn ngữ
- area_str_code: Mã khu vực
- uid_place: ID địa điểm
- type: Loại bài viết
- category: Danh mục
- title: Tiêu đề
- des: Mô tả
- content: Nội dung
- sent: Trạng thái gửi (0/1)
- status: Trạng thái hoạt động (0/1)
- approved: Trạng thái phê duyệt (0/1)
- date_insert: Ngày tạo
- date_update: Ngày cập nhật

## Lưu ý

1. Module này phụ thuộc vào các module khác:

   - Language (ngôn ngữ)
   - Area (khu vực)
   - Place (địa điểm)

2. Cần đảm bảo người dùng đã đăng nhập để sử dụng các tính năng

3. Các file JavaScript sử dụng jQuery cho AJAX calls

4. Module tuân theo pattern MVC của framework hiện tại
