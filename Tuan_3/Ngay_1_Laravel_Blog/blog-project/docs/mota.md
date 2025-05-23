# Kiến trúc dự án Laravel Blog đa ngôn ngữ

## Vai trò của từng thư mục chính

- **app/Http**  
  Chứa các controller, middleware, request, và logic xử lý HTTP request và response.

- **app/Providers**  
  Chứa các Service Provider dùng để đăng ký services, bindings, event, config...

- **resources/views**  
  Chứa các file Blade templates (giao diện frontend).

- **routes/**  
  Định nghĩa các route (web.php, api.php,...).

- **storage/**  
  Lưu trữ cache, logs, files upload, sessions, compiled views,...

- **bootstrap/**  
  Thư mục bootstrap khởi tạo framework, tải autoload, config ứng dụng.

## Service Container trong Laravel

Service Container là một công cụ để quản lý các dependency (phụ thuộc) và tự động tiêm (injection) các dịch vụ (services) khi cần thiết.

Laravel sử dụng Service Container để:

- Bind các interface với implementation tương ứng.
- Quản lý lifecycle các object (singleton, transient).
- Giúp Dependency Injection hoạt động mượt mà, tăng tính mở rộng và test dễ dàng.

Service Container được cấu hình thông qua các Service Provider nằm trong thư mục `app/Providers`.
