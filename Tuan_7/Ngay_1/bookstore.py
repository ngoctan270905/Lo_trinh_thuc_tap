import tkinter as tk
from tkinter import messagebox, font, ttk

# Dữ liệu sách
books = [
    {"ten": "Đắc Nhân Tâm", "gia": 75000, "ton_kho": 20, "ban_duoc": 15},
    {"ten": "Dám Nghĩ Lớn", "gia": 45000, "ton_kho": 5, "ban_duoc": 8},
    {"ten": "7 Thói Quen", "gia": 120000, "ton_kho": 2, "ban_duoc": 11},
    {"ten": "Tư Duy Nhanh và Chậm", "gia": 99000, "ton_kho": 0, "ban_duoc": 14},
    {"ten": "Sapiens", "gia": 150000, "ton_kho": 3, "ban_duoc": 20}
]

# Hàm kiểm tra tồn kho và phân loại
def check_stock_gui():
    ten_sach = entry_ten_sach.get()
    try:
        so_luong = int(entry_so_luong.get())
    except ValueError:
        messagebox.showerror("Lỗi", "Số lượng phải là số nguyên.")
        return

    for book in books:
        if book["ten"] == ten_sach:
            if book["ton_kho"] >= so_luong:
                trang_thai = "✅ Còn hàng"
            else:
                trang_thai = "❌ Hết hàng hoặc không đủ"

            if book["gia"] < 50000:
                phan_loai = "Sách giá rẻ"
            elif book["gia"] <= 100000:
                phan_loai = "Sách trung bình"
            else:
                phan_loai = "Sách cao cấp"

            messagebox.showinfo("Kiểm tra tồn kho", f"{trang_thai}\nPhân loại: {phan_loai}")
            return
    messagebox.showwarning("Không tìm thấy", "Không tìm thấy sách.")

# Hàm tính hóa đơn
def calculate_bill_gui():
    ten_sach = entry_ten_sach.get()
    try:
        so_luong = int(entry_so_luong.get())
    except ValueError:
        messagebox.showerror("Lỗi", "Số lượng phải là số nguyên.")
        return

    loai = var_loai_khach.get()
    for book in books:
        if book["ten"] == ten_sach:
            if book["ton_kho"] == 0:
                messagebox.showerror("Hết hàng", "Sách đã hết hàng.")
                return
            tong = book["gia"] * so_luong
            if loai == "VIP":
                tong *= 0.9
            messagebox.showinfo("Hóa đơn", f"Tổng tiền: {tong:.0f} VND")
            return
    messagebox.showerror("Không tìm thấy", "Không tìm thấy sách.")

# Hàm tạo mã giảm giá
def tao_ma_giam_gia_gui():
    ten = entry_ten_khach.get()
    loai = var_loai_khach.get()
    ma = ten.upper() + ("_VIP" if loai == "VIP" else "_REG")
    messagebox.showinfo("Mã giảm giá", f"Mã giảm giá: {ma}")

# In sách bán chạy
def sach_ban_chay_gui():
    danh_sach = [book["ten"] for book in books if book["ban_duoc"] > 10]
    if danh_sach:
        messagebox.showinfo("Sách bán chạy", "\n".join(danh_sach))
    else:
        messagebox.showinfo("Sách bán chạy", "Không có sách nào bán > 10.")

# Tìm sách bán chạy nhất
def top_sach_gui():
    i = 1
    max_index = 0
    while i < len(books):
        if books[i]["ban_duoc"] > books[max_index]["ban_duoc"]:
            max_index = i
        i += 1
    book = books[max_index]
    messagebox.showinfo("Sách bán chạy nhất", f"{book['ten']}: {book['ban_duoc']} bản")

# ==== GIAO DIỆN ====
root = tk.Tk()
root.title("📚 Quản Lý Cửa Hàng Sách")
root.geometry("500x700")
root.resizable(False, False)

# Font đẹp
app_font = ("Segoe UI", 11)
label_font = ("Segoe UI", 10, "bold")

# Widgets nhập liệu
tk.Label(root, text="Tên sách:", font=label_font).pack(anchor="w", padx=20, pady=(15, 0))
entry_ten_sach = tk.Entry(root, font=app_font)
entry_ten_sach.pack(fill="x", padx=20)

tk.Label(root, text="Số lượng mua:", font=label_font).pack(anchor="w", padx=20, pady=(10, 0))
entry_so_luong = tk.Entry(root, font=app_font)
entry_so_luong.pack(fill="x", padx=20)

tk.Label(root, text="Tên khách hàng:", font=label_font).pack(anchor="w", padx=20, pady=(10, 0))
entry_ten_khach = tk.Entry(root, font=app_font)
entry_ten_khach.pack(fill="x", padx=20)

tk.Label(root, text="Loại khách hàng:", font=label_font).pack(anchor="w", padx=20, pady=(10, 0))
var_loai_khach = tk.StringVar(value="Thường")
tk.OptionMenu(root, var_loai_khach, "Thường", "VIP").pack(fill="x", padx=20)

# Nút chức năng
btn_opts = {"font": app_font, "padx": 10, "pady": 5, "width": 25}
tk.Button(root, text="1. Kiểm tra tồn kho", command=check_stock_gui, **btn_opts).pack(pady=4)
tk.Button(root, text="2. Tính hóa đơn", command=calculate_bill_gui, **btn_opts).pack(pady=4)
tk.Button(root, text="3. Tạo mã giảm giá", command=tao_ma_giam_gia_gui, **btn_opts).pack(pady=4)
tk.Button(root, text="4. Danh sách bán chạy", command=sach_ban_chay_gui, **btn_opts).pack(pady=4)
tk.Button(root, text="5. Sách bán chạy nhất", command=top_sach_gui, **btn_opts).pack(pady=4)

# ====== BẢNG HIỂN THỊ DANH SÁCH SÁCH ======
tk.Label(root, text="Danh sách sách trong cửa hàng:", font=label_font).pack(anchor="w", padx=20, pady=(10, 0))
tree_books = ttk.Treeview(root, columns=("ten", "gia", "ton_kho", "ban_duoc"), show="headings", height=6)
tree_books.heading("ten", text="Tên sách")
tree_books.heading("gia", text="Giá (VND)")
tree_books.heading("ton_kho", text="Tồn kho")
tree_books.heading("ban_duoc", text="Đã bán")
tree_books.pack(fill="x", padx=20, pady=10)

def refresh_book_list():
    for row in tree_books.get_children():
        tree_books.delete(row)
    for book in books:
        tree_books.insert("", "end", values=(book["ten"], f"{book['gia']:,}", book["ton_kho"], book["ban_duoc"]))

refresh_book_list()

# Khởi chạy
root.mainloop()
