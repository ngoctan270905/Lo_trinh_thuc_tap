import tkinter as tk
from tkinter import ttk, messagebox
import numpy as np

# ==== DỮ LIỆU MẪU ====0
events = [
    {"id": "EV001", "name": "Hội chợ sách", "ticket_price": 50000.0, "tickets_left": 200},
    {"id": "EV002", "name": "Triển lãm nghệ thuật", "ticket_price": 75000.0, "tickets_left": 50},
    {"id": "EV003", "name": "Workshop Python", "ticket_price": 30000.0, "tickets_left": 15},
    {"id": "EV004", "name": "Đêm nhạc dân gian", "ticket_price": 100000.0, "tickets_left": 5},
    {"id": "EV005", "name": "Chiếu phim miễn phí", "ticket_price": 0.0, "tickets_left": 100}
]

sponsors = {
    "SP001": ("Công ty A", 5000000.0),
    "SP002": ("Công ty B", 3000000.0),
}

sold_events_set = set()
ticket_history = []  # List of dicts: {"event_id", "ticket_id", "quantity"}

# ==== HÀM XỬ LÝ ====

def add_event(event_id, name, price, quantity):
    if any(ev["id"] == event_id for ev in events):
        messagebox.showerror("Lỗi", "Mã sự kiện đã tồn tại.")
        return
    events.append({"id": event_id, "name": name, "ticket_price": price, "tickets_left": quantity})
    messagebox.showinfo("Thành công", f"Đã thêm sự kiện {name}.")
    refresh_event_table()

def update_event_quantity(event_id, quantity):
    for ev in events:
        if ev["id"] == event_id:
            ev["tickets_left"] = quantity
            messagebox.showinfo("Cập nhật", f"Đã cập nhật số vé còn lại cho {ev['name']}.")
            refresh_event_table()
            return
    messagebox.showerror("Lỗi", "Không tìm thấy sự kiện.")

def find_event(event_id):
    for ev in events:
        if ev["id"] == event_id:
            return ev
    return None

def add_sponsor(sponsor_id, name, amount):
    if sponsor_id in sponsors:
        messagebox.showerror("Lỗi", "Mã tài trợ đã tồn tại.")
        return
    sponsors[sponsor_id] = (name, amount)
    messagebox.showinfo("Thành công", f"Đã thêm nhà tài trợ {name}.")
    refresh_sponsor_table()

def update_sponsor_amount(sponsor_id, new_amount):
    if sponsor_id in sponsors:
        name, _ = sponsors[sponsor_id]
        sponsors[sponsor_id] = (name, new_amount)
        messagebox.showinfo("Cập nhật", f"Đã cập nhật tài trợ của {name}.")
        refresh_sponsor_table()
    else:
        messagebox.showerror("Lỗi", "Không tìm thấy nhà tài trợ.")

def process_ticket_sale(event_id, ticket_id, quantity):
    ev = find_event(event_id)
    if not ev:
        messagebox.showerror("Lỗi", "Không tìm thấy sự kiện.")
        return
    if quantity <= 0:
        messagebox.showerror("Lỗi", "Số lượng phải lớn hơn 0.")
        return
    if ev["tickets_left"] < quantity:
        messagebox.showerror("Lỗi", "Không đủ vé.")
        return
    ev["tickets_left"] -= quantity
    sold_events_set.add(event_id)
    ticket_history.append({"event_id": event_id, "ticket_id": ticket_id, "quantity": quantity})
    messagebox.showinfo("Bán vé", f"Đã bán {quantity} vé cho {ev['name']}")
    refresh_ticket_table()
    refresh_event_table()

def generate_report():
    low_ticket_events = [ev["name"] for ev in events if ev["tickets_left"] < 20]
    total_value = sum(ev["ticket_price"] * ev["tickets_left"] for ev in events)
    sold_ids = set(s["event_id"] for s in ticket_history)

    result = f"Sự kiện sắp hết vé: {', '.join(low_ticket_events) or 'Không có'}\n"
    result += f"Tổng giá trị vé còn lại: {int(total_value):,} VNĐ\n"
    result += f"Sự kiện đã bán vé: {', '.join(sold_ids) or 'Chưa có'}"

    messagebox.showinfo("Báo cáo thống kê", result)

# ==== GIAO DIỆN ====

root = tk.Tk()
root.title("Quản Lý Sự Kiện Văn Hóa")
root.geometry("800x600")

notebook = ttk.Notebook(root)
notebook.pack(fill="both", expand=True, padx=10, pady=10)

# ==== TAB 1: Sự kiện ====
tab1 = ttk.Frame(notebook)
notebook.add(tab1, text="Sự kiện")

tk.Label(tab1, text="Mã sự kiện").pack()
e_id = tk.Entry(tab1)
e_id.pack()

tk.Label(tab1, text="Tên sự kiện").pack()
e_name = tk.Entry(tab1)
e_name.pack()

tk.Label(tab1, text="Giá vé").pack()
e_price = tk.Entry(tab1)
e_price.pack()

tk.Label(tab1, text="Số vé còn").pack()
e_qty = tk.Entry(tab1)
e_qty.pack()

tk.Button(tab1, text="➕ Thêm sự kiện", command=lambda: add_event(
    e_id.get(), e_name.get(), float(e_price.get()), int(e_qty.get()))).pack(pady=3)

tk.Button(tab1, text="📝 Cập nhật vé", command=lambda: update_event_quantity(
    e_id.get(), int(e_qty.get()))).pack(pady=3)

tk.Button(tab1, text="📋 Xem báo cáo", command=generate_report).pack(pady=3)

# Bảng hiển thị sự kiện
tree_events = ttk.Treeview(tab1, columns=("id", "name", "price", "left"), show="headings")
tree_events.heading("id", text="Mã sự kiện")
tree_events.heading("name", text="Tên sự kiện")
tree_events.heading("price", text="Giá vé (VNĐ)")
tree_events.heading("left", text="Số vé còn")
tree_events.pack(pady=10, fill="x")

def refresh_event_table():
    for i in tree_events.get_children():
        tree_events.delete(i)
    for ev in events:
        tree_events.insert("", "end", values=(
            ev["id"], ev["name"], f"{ev['ticket_price']:,.0f}", ev["tickets_left"]
        ))

refresh_event_table()

# ==== TAB 2: Tài trợ ====
tab2 = ttk.Frame(notebook)
notebook.add(tab2, text="Tài trợ")

tk.Label(tab2, text="Mã nhà tài trợ").pack()
s_id = tk.Entry(tab2)
s_id.pack()

tk.Label(tab2, text="Tên công ty").pack()
s_name = tk.Entry(tab2)
s_name.pack()

tk.Label(tab2, text="Số tiền tài trợ").pack()
s_amt = tk.Entry(tab2)
s_amt.pack()

tk.Button(tab2, text="➕ Thêm nhà tài trợ", command=lambda: add_sponsor(
    s_id.get(), s_name.get(), float(s_amt.get()))).pack(pady=3)

tk.Button(tab2, text="📝 Cập nhật tài trợ", command=lambda: update_sponsor_amount(
    s_id.get(), float(s_amt.get()))).pack(pady=3)

# Bảng danh sách nhà tài trợ
tree_sponsors = ttk.Treeview(tab2, columns=("id", "name", "amount"), show="headings")
tree_sponsors.heading("id", text="Mã")
tree_sponsors.heading("name", text="Tên nhà tài trợ")
tree_sponsors.heading("amount", text="Số tiền (VNĐ)")
tree_sponsors.pack(pady=10, fill="x")

def refresh_sponsor_table():
    for i in tree_sponsors.get_children():
        tree_sponsors.delete(i)
    for sid, (name, amount) in sponsors.items():
        tree_sponsors.insert("", "end", values=(sid, name, f"{amount:,.0f}"))

refresh_sponsor_table()

# ==== TAB 3: Bán vé ====
tab3 = ttk.Frame(notebook)
notebook.add(tab3, text="Bán vé")

tk.Label(tab3, text="Mã sự kiện").pack()
t_event = tk.Entry(tab3)
t_event.pack()

tk.Label(tab3, text="Mã vé (ex: TICKET_001)").pack()
t_id = tk.Entry(tab3)
t_id.pack()

tk.Label(tab3, text="Số lượng").pack()
t_qty = tk.Entry(tab3)
t_qty.pack()

tk.Button(tab3, text="💸 Bán vé", command=lambda: process_ticket_sale(
    t_event.get(), t_id.get(), int(t_qty.get()))).pack(pady=3)

tk.Button(tab3, text="📊 Báo cáo", command=generate_report).pack(pady=3)

# Bảng giao dịch vé đã bán
tree_tickets = ttk.Treeview(tab3, columns=("event", "ticket", "qty"), show="headings")
tree_tickets.heading("event", text="Mã sự kiện")
tree_tickets.heading("ticket", text="Mã vé")
tree_tickets.heading("qty", text="Số lượng")
tree_tickets.pack(pady=10, fill="x")

def refresh_ticket_table():
    for i in tree_tickets.get_children():
        tree_tickets.delete(i)
    for item in ticket_history:
        tree_tickets.insert("", "end", values=(item["event_id"], item["ticket_id"], item["quantity"]))

# ==== KHỞI CHẠY ====
root.mainloop()
