import re
import json
import pendulum  

# ===== DANH SÁCH KHÓA HỌC MẪU =====
course_catalog = {
    "KH001": 1500000,
    "KH002": 1200000,
    "KH003": 980000,
    "KH004": 2100000,
}

# ===== HÀM KIỂM TRA DỮ LIỆU =====
def validate_input(name, email, course_code):
    if len(name.strip()) < 3:
        raise ValueError("Tên phải dài ít nhất 3 ký tự.")

    if not re.match(r"^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$", email):
        raise ValueError("Email không đúng định dạng.")

    if not re.match(r"^KH\d{3}$", course_code):
        raise ValueError("Mã khóa học phải đúng định dạng KHxxx.")

    if course_code not in course_catalog:
        raise ValueError("Mã khóa học không tồn tại.")

# ===== HÀM TÍNH CHI PHÍ KHÓA HỌC =====
def calculate_cost(course_code, quantity, discount_code=None):
    base_price = course_catalog[course_code]
    total = base_price * quantity

    if discount_code == "SUMMER25":
        total *= 0.75
    elif discount_code == "EARLYBIRD":
        total *= 0.85

    return round(total, 2)

# ===== HÀM LƯU VÀ ĐỌC FILE JSON =====
def save_registration(data, filename="registrations.json"):
    try:
        with open(filename, "r", encoding="utf-8") as f:
            registrations = json.load(f)
    except (FileNotFoundError, json.JSONDecodeError):
        registrations = []

    registrations.append(data)

    with open(filename, "w", encoding="utf-8") as f:
        json.dump(registrations, f, indent=2, ensure_ascii=False)

def load_registrations(filename="registrations.json"):
    try:
        with open(filename, "r", encoding="utf-8") as f:
            registrations = json.load(f)
        for r in registrations:
            print(f"Đăng ký của {r['name']}: Khóa học {r['course_code']}, Ngày {r['date']}, Chi phí {r['cost']} VNĐ")
    except (FileNotFoundError, json.JSONDecodeError):
        print("Chưa có dữ liệu đăng ký hoặc file lỗi.")

# ===== HÀM MAIN =====
def main():
    try:
        name = input("Nhập họ tên: ")
        email = input("Nhập email: ")
        course_code = input("Nhập mã khóa học (VD: KH001): ")
        quantity = int(input("Số lượng đăng ký: "))
        discount_code = input("Nhập mã giảm giá (nếu có): ").strip().upper()

        validate_input(name, email, course_code)
        cost = calculate_cost(course_code, quantity, discount_code)

        date_now = pendulum.now().format("YYYY-MM-DD")

        print(f"\n Chúc mừng {name} đã đăng ký khóa học {course_code} vào ngày {date_now}!")
        print(f"Tổng chi phí: {cost} VNĐ\n")

        registration_data = {
            "name": name,
            "email": email,
            "course_code": course_code,
            "quantity": quantity,
            "date": date_now,
            "cost": cost
        }

        save_registration(registration_data)
        print("Danh sách đăng ký hiện tại:")
        load_registrations()

    except ValueError as ve:
        print(f"Lỗi: {ve}")
    except Exception as e:
        print(f"Có lỗi xảy ra: {e}")

# ===== CHẠY CHƯƠNG TRÌNH =====
if __name__ == "__main__":
    main()
