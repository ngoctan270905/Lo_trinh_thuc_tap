import tkinter as tk
from tkinter import messagebox, ttk
import mysql.connector

def connect_db():
    return mysql.connector.connect(
        host="localhost",
        user="root",
        password="",
        database="project_progress"
    )

def query_week_data():
    try:
        week = int(week_entry.get())
    except ValueError:
        messagebox.showerror("Lỗi", "Vui lòng nhập số tuần hợp lệ.")
        return

    try:
        conn = connect_db()
        cursor = conn.cursor()
        query = """
        SELECT m.name, wp.hours_worked, wp.tasks_completed, wp.notes
        FROM weekly_progress wp
        JOIN members m ON wp.member_id = m.member_id
        WHERE wp.week_number = %s
        ORDER BY wp.tasks_completed DESC
        LIMIT 5
        """
        cursor.execute(query, (week,))
        results = cursor.fetchall()

        for row in result_table.get_children():
            result_table.delete(row)

        for row in results:
            result_table.insert('', 'end', values=row)

        if not results:
            messagebox.showinfo("Thông báo", f"Không có dữ liệu cho tuần {week}.")

    except mysql.connector.Error as err:
        messagebox.showerror("Lỗi CSDL", str(err))
    finally:
        if conn.is_connected():
            cursor.close()
            conn.close()

# Giao diện chính
root = tk.Tk()
root.title("Quản lý Tiến độ Dự án")
root.geometry("700x400")

frame = tk.Frame(root, padx=20, pady=20)
frame.pack(fill="both", expand=True)

label = tk.Label(frame, text="Nhập số tuần:", font=("Arial", 12))
label.grid(row=0, column=0, sticky="w")

week_entry = tk.Entry(frame, width=10, font=("Arial", 12))
week_entry.grid(row=0, column=1, sticky="w", padx=(5, 20))

btn = tk.Button(frame, text="Truy vấn", command=query_week_data, bg="#4CAF50", fg="white", font=("Arial", 12, "bold"))
btn.grid(row=0, column=2)

cols = ("Tên thành viên", "Số giờ làm", "Nhiệm vụ", "Ghi chú")
result_table = ttk.Treeview(frame, columns=cols, show="headings", height=10)
for col in cols:
    result_table.heading(col, text=col)
    result_table.column(col, anchor="center", width=150)
result_table.grid(row=1, column=0, columnspan=3, pady=20)

root.mainloop()
