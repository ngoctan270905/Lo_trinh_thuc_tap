import tkinter as tk
from tkinter import messagebox, simpledialog, scrolledtext
import os

def create_log():
    try:
        week = simpledialog.askinteger("1️⃣ Tạo nhật ký", "Tuần:")
        hours = simpledialog.askfloat("1️⃣ Tạo nhật ký", "Nhập số giờ làm việc:")
        tasks = simpledialog.askinteger("1️⃣ Tạo nhật ký", "Nhập số nhiệm vụ hoàn thành:")
        note = simpledialog.askstring("1️⃣ Tạo nhật ký", "Nhập ghi chú:")

        if None in (week, hours, tasks, note): return

        with open(f"week_{week}.txt", "w", encoding="utf-8") as f:
            f.write(f"Tuần: {week}\n")
            f.write(f"Số giờ làm việc: {hours}\n")
            f.write(f"Nhiệm vụ hoàn thành: {tasks}\n")
            f.write(f"Ghi chú: {note}\n")
        messagebox.showinfo("Thành công", f"Đã tạo nhật ký tuần {week}")
    except:
        messagebox.showerror("Lỗi", "Dữ liệu không hợp lệ!")

def read_log():
    week = simpledialog.askinteger("2️⃣ Đọc nhật ký", "Nhập số tuần cần đọc:")
    if week is None: return
    filename = f"week_{week}.txt"
    if os.path.exists(filename):
        with open(filename, "r", encoding="utf-8") as f:
            content = f.read()
        show_text("📖 Nội dung nhật ký", content)
    else:
        messagebox.showwarning("Không tìm thấy", f"Nhật ký tuần {week} không tồn tại.")

# Hàm cập nhật nhật ký tuần
def update_log():
    try:
        week = simpledialog.askinteger("3️⃣ Cập nhật nhật ký", "Nhập số tuần cần cập nhật:")
        hours = simpledialog.askfloat("3️⃣ Cập nhật nhật ký", "Nhập số giờ làm việc mới:")
        tasks = simpledialog.askinteger("3️⃣ Cập nhật nhật ký", "Nhập số nhiệm vụ hoàn thành mới:")
        note = simpledialog.askstring("3️⃣ Cập nhật nhật ký", "Nhập ghi chú mới:")

        if None in (week, hours, tasks, note): return

        with open(f"week_{week}.txt", "w", encoding="utf-8") as f:
            f.write(f"Tuần: {week}\n")
            f.write(f"Số giờ làm việc: {hours}\n")
            f.write(f"Nhiệm vụ hoàn thành: {tasks}\n")
            f.write(f"Ghi chú: {note}\n")
        messagebox.showinfo("Thành công", f"Đã cập nhật nhật ký tuần {week}")
    except:
        messagebox.showerror("Lỗi", "Dữ liệu không hợp lệ!")

# Hàm xóa nhật ký
def delete_log():
    week = simpledialog.askinteger("4️⃣ Xóa nhật ký", "Nhập số tuần cần xóa:")
    if week is None: return
    filename = f"week_{week}.txt"
    if os.path.exists(filename):
        os.remove(filename)
        messagebox.showinfo("Đã xóa", f"Đã xóa nhật ký tuần {week}")
    else:
        messagebox.showwarning("Không tìm thấy", f"Nhật ký tuần {week} không tồn tại.")

# Hàm tạo báo cáo tổng kết
def generate_summary():
    total_weeks = 0
    total_hours = 0.0
    total_tasks = 0

    for file in os.listdir():
        if file.startswith("week_") and file.endswith(".txt"):
            total_weeks += 1
            with open(file, "r", encoding="utf-8") as f:
                for line in f.readlines():
                    if "Số giờ làm việc:" in line:
                        total_hours += float(line.split(":")[1].strip())
                    elif "Nhiệm vụ hoàn thành:" in line:
                        total_tasks += int(line.split(":")[1].strip())

    report = f"""📊 Báo cáo tổng kết:
- Tổng số tuần: {total_weeks}
- Tổng số giờ làm việc: {total_hours}
- Tổng số nhiệm vụ hoàn thành: {total_tasks}"""
    show_text("📊 Báo cáo tổng kết", report)


def show_all_logs():
    logs = []
    for file in sorted(os.listdir()):
        if file.startswith("week_") and file.endswith(".txt"):
            with open(file, "r", encoding="utf-8") as f:
                lines = f.readlines()
                try:
                    week = lines[0].strip().split(":")[1].strip()
                    hours = lines[1].strip().split(":")[1].strip()
                    tasks = lines[2].strip().split(":")[1].strip()
                    note = lines[3].strip().split(":")[1].strip()
                    logs.append(f"Tuần {week} - Giờ: {hours} - Nhiệm vụ: {tasks} - Ghi chú: {note}")
                except:
                    logs.append(f"{file}: lỗi định dạng")
    if logs:
        content = "\n".join(logs)
        show_text("📂 Danh sách các nhật ký hiện có", content)
    else:
        messagebox.showinfo("Danh sách trống", "Không có nhật ký nào được lưu.")


def show_text(title, content):
    win = tk.Toplevel(root)
    win.title(title)
    text_area = scrolledtext.ScrolledText(win, width=50, height=15, font=("Arial", 12))
    text_area.pack(padx=10, pady=10)
    text_area.insert(tk.END, content)
    text_area.config(state='disabled')

# Giao diện chính
root = tk.Tk()
root.title("📘 Công cụ quản lý nhật ký tuần")
root.geometry("400x480")
root.resizable(False, False)

tk.Label(root, text="📅 Nhật ký tuần làm việc", font=("Arial", 16, "bold")).pack(pady=20)

tk.Button(root, text="1️. Tạo nhật ký tuần", command=create_log, width=30, height=2).pack(pady=5)
tk.Button(root, text="2️. Đọc nhật ký tuần", command=read_log, width=30, height=2).pack(pady=5)
tk.Button(root, text="3️. Cập nhật nhật ký tuần", command=update_log, width=30, height=2).pack(pady=5)
tk.Button(root, text="4️. Xóa nhật ký tuần", command=delete_log, width=30, height=2).pack(pady=5)
tk.Button(root, text="5️. Tạo báo cáo tổng kết", command=generate_summary, width=30, height=2).pack(pady=5)
tk.Button(root, text="6️. Danh sách nhật ký hiện có", command=show_all_logs, width=30, height=2).pack(pady=5)
tk.Button(root, text="❌ Thoát", command=root.quit, width=30, height=2, bg="lightgray").pack(pady=20)

root.mainloop()
