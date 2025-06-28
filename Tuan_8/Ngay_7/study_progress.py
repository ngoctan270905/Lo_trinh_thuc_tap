import tkinter as tk
from tkinter import messagebox, ttk
import pandas as pd
import matplotlib.pyplot as plt
import os

CSV_FILE = "progress.csv"

# -----------------------------------
# 1. Lưu dữ liệu nhập từ giao diện
# -----------------------------------
def save_data(name, week, exercises, score):
    if not os.path.exists(CSV_FILE):
        df = pd.DataFrame(columns=["Tên", "Tuần", "Bài tập", "Điểm"])
    else:
        df = pd.read_csv(CSV_FILE)

    new_entry = {"Tên": name, "Tuần": int(week), "Bài tập": int(exercises), "Điểm": float(score)}
    df = pd.concat([df, pd.DataFrame([new_entry])], ignore_index=True)
    df.to_csv(CSV_FILE, index=False)
    messagebox.showinfo("Thành công", "Đã lưu dữ liệu học viên!")

# -----------------------------------
# 2. Giao diện nhập liệu
# -----------------------------------
def open_input_window():
    input_win = tk.Toplevel(root)
    input_win.title("📥 Nhập dữ liệu học viên")
    input_win.geometry("300x300")

    tk.Label(input_win, text="Tên học viên").pack()
    entry_name = tk.Entry(input_win)
    entry_name.pack()

    tk.Label(input_win, text="Tuần (1–3)").pack()
    entry_week = tk.Entry(input_win)
    entry_week.pack()

    tk.Label(input_win, text="Số bài tập").pack()
    entry_ex = tk.Entry(input_win)
    entry_ex.pack()

    tk.Label(input_win, text="Điểm (0–10)").pack()
    entry_score = tk.Entry(input_win)
    entry_score.pack()

    def submit():
        name = entry_name.get()
        week = entry_week.get()
        ex = entry_ex.get()
        score = entry_score.get()
        if not (name and week and ex and score):
            messagebox.showwarning("Thiếu dữ liệu", "Vui lòng nhập đầy đủ")
            return
        try:
            save_data(name, int(week), int(ex), float(score))
            input_win.destroy()
        except:
            messagebox.showerror("Lỗi", "Dữ liệu không hợp lệ!")

    tk.Button(input_win, text="Lưu", command=submit, bg="lightblue").pack(pady=10)

# -----------------------------------
# 3. Phân tích & trực quan hóa
# -----------------------------------
def analyze_and_visualize():
    if not os.path.exists(CSV_FILE):
        messagebox.showerror("Lỗi", "Không có file dữ liệu!")
        return

    df = pd.read_csv(CSV_FILE)
    if df.empty:
        messagebox.showwarning("Trống", "Dữ liệu rỗng!")
        return

    # -------- Phân tích tuần cuối --------
    latest_week = df["Tuần"].max()
    df_week = df[df["Tuần"] == latest_week]
    avg_ex = df_week["Bài tập"].mean()
    avg_score = df_week["Điểm"].mean()
    top_student = df_week.loc[df_week["Điểm"].idxmax()]["Tên"]

    result = f"""📊 Phân tích tuần {latest_week}:
- Bài tập trung bình: {avg_ex:.2f}
- Điểm trung bình: {avg_score:.2f}
- Học viên xuất sắc: {top_student}
"""
    messagebox.showinfo("Phân tích", result)

    # -------- Biểu đồ đường --------
    plt.figure(figsize=(8, 5))
    for name, group in df.groupby("Tên"):
        plt.plot(group["Tuần"], group["Điểm"], marker='o', label=name)
    plt.title("📈 Xu hướng điểm qua các tuần")
    plt.xlabel("Tuần")
    plt.ylabel("Điểm")
    plt.legend()
    plt.grid(True)
    plt.tight_layout()
    plt.savefig("trend.png")
    plt.close()

    # -------- Biểu đồ cột --------
    avg_ex_by_week = df.groupby("Tuần")["Bài tập"].mean()
    plt.figure(figsize=(6, 4))
    avg_ex_by_week.plot(kind="bar", color="orange")
    plt.title("📊 Trung bình bài tập mỗi tuần")
    plt.xlabel("Tuần")
    plt.ylabel("Số bài")
    plt.tight_layout()
    plt.savefig("comparison.png")
    plt.close()

    # -------- Biểu đồ tròn --------
    summary = df.groupby("Tên")["Bài tập"].sum()
    plt.figure(figsize=(6, 6))
    plt.pie(summary, labels=summary.index, autopct="%1.1f%%")
    plt.title("🍰 Tỉ lệ đóng góp bài tập")
    plt.tight_layout()
    plt.savefig("contribution.png")
    plt.close()

    messagebox.showinfo("Hoàn tất", "Đã tạo biểu đồ: trend.png, comparison.png, contribution.png")

# -----------------------------------
# Giao diện chính Tkinter
# -----------------------------------
root = tk.Tk()
root.title("📚 Phân tích tiến độ học tập")
root.geometry("360x300")
root.resizable(False, False)

tk.Label(root, text="📘 Công cụ theo dõi học tập", font=("Arial", 16, "bold")).pack(pady=20)

tk.Button(root, text="➕ Nhập dữ liệu học viên", command=open_input_window, width=30, height=2).pack(pady=5)
tk.Button(root, text="📊 Phân tích & Biểu đồ", command=analyze_and_visualize, width=30, height=2).pack(pady=5)
tk.Button(root, text="❌ Thoát", command=root.quit, bg="lightgray", width=30, height=2).pack(pady=20)

root.mainloop()
