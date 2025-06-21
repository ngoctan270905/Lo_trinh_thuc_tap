# main.py
import tkinter as tk
from tkinter import ttk, messagebox
from book_management import PhysicalBook, EBook
from library_management import Library, User

# === Khởi tạo dữ liệu mẫu ===
lib = Library()
lib.add_book(PhysicalBook("P001", "Đắc Nhân Tâm", "Carnegie", 3, "Mới"))
lib.add_book(PhysicalBook("P002", "Dám Nghĩ Lớn", "Schwartz", 2, "Cũ"))
lib.add_book(PhysicalBook("P003", "7 Thói Quen", "Covey", 1, "Mới"))
lib.add_book(EBook("E001", "Sapiens", "Harari", 10, "PDF"))
lib.add_book(EBook("E002", "Tư Duy Nhanh", "Kahneman", 6, "EPUB"))

users = {
    "U001": User("U001", "An"),
    "U002": User("U002", "Bình")
}

# === Giao diện tkinter ===
root = tk.Tk()
root.title("Quản Lý Thư Viện Sách")
root.geometry("750x500")

notebook = ttk.Notebook(root)
notebook.pack(fill="both", expand=True)

# === TAB SÁCH ===
tab_books = ttk.Frame(notebook)
notebook.add(tab_books, text="Danh sách sách")

tree_books = ttk.Treeview(tab_books, columns=("ma", "info"), show="headings")
tree_books.heading("ma", text="Mã sách")
tree_books.heading("info", text="Thông tin")
tree_books.pack(fill="both", expand=True)

def refresh_books():
    for i in tree_books.get_children():
        tree_books.delete(i)
    for b in lib:
        tree_books.insert("", "end", values=(b.get_ma_sach(), b.get_info()))

refresh_books()

# === TAB NGƯỜI DÙNG ===
tab_users = ttk.Frame(notebook)
notebook.add(tab_users, text="Người dùng")

tree_users = ttk.Treeview(tab_users, columns=("ma", "ten", "muon"), show="headings")
tree_users.heading("ma", text="Mã")
tree_users.heading("ten", text="Tên")
tree_users.heading("muon", text="Sách đang mượn")
tree_users.pack(fill="both", expand=True)

def refresh_users():
    for i in tree_users.get_children():
        tree_users.delete(i)
    for user in users.values():
        borrowed = ", ".join(user.get_borrowed_books())
        tree_users.insert("", "end", values=(user.get_ma(), user.ten, borrowed))

refresh_users()

# === TAB MƯỢN TRẢ ===
tab_borrow = ttk.Frame(notebook)
notebook.add(tab_borrow, text="🔁 Mượn / Trả sách")

tk.Label(tab_borrow, text="Mã người dùng:").pack()
entry_user = tk.Entry(tab_borrow)
entry_user.pack()

tk.Label(tab_borrow, text="Mã sách:").pack()
entry_book = tk.Entry(tab_borrow)
entry_book.pack()

def muon():
    uid = entry_user.get()
    bid = entry_book.get()
    if uid in users:
        found = False
        for b in lib:
            if b.get_ma_sach() == bid:
                users[uid].borrow_book(bid)
                b.update_stock(max(0, b.ton_kho - 1))
                found = True
                break
        if found:
            messagebox.showinfo("Thành công", f"{uid} đã mượn sách {bid}")
        else:
            messagebox.showerror("Lỗi", "Không tìm thấy mã sách.")
    else:
        messagebox.showerror("Lỗi", "Không tìm thấy người dùng.")
    refresh_users()
    refresh_books()

def tra():
    uid = entry_user.get()
    bid = entry_book.get()
    if uid in users:
        users[uid].return_book(bid)
        for b in lib:
            if b.get_ma_sach() == bid:
                b.update_stock(b.ton_kho + 1)
                break
        messagebox.showinfo("Trả sách", f"{uid} đã trả sách {bid}")
    refresh_users()
    refresh_books()

tk.Button(tab_borrow, text="📖 Mượn sách", command=muon).pack(pady=5)
tk.Button(tab_borrow, text="📕 Trả sách", command=tra).pack(pady=5)

root.mainloop()
