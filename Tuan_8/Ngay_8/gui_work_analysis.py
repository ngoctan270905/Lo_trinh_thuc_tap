import numpy as np
from scipy import stats, optimize
import tkinter as tk
from tkinter import messagebox, scrolledtext
import os

FILENAME = "performance.npy"

# ========================
# Phần xử lý dữ liệu
# ========================

def create_performance_data():
    np.random.seed(0)
    hours = np.random.normal(40, 2, (4, 5))
    tasks = np.random.poisson(5, (4, 5))
    data = np.stack((hours, tasks), axis=2)
    np.save(FILENAME, data)
    return "Đã tạo dữ liệu mẫu và lưu vào performance.npy"

def basic_analysis():
    if not os.path.exists(FILENAME):
        return "Không tìm thấy file dữ liệu."
    data = np.load(FILENAME)
    results = []
    for week_idx, week in enumerate(data, 1):
        hours = week[:, 0]
        tasks = week[:, 1]
        avg_hours = np.mean(hours)
        std_hours = np.std(hours)
        total_tasks = int(np.sum(tasks))
        best_member = int(np.argmax(tasks))
        best_tasks = int(tasks[best_member])
        results.append(
            f"Phân tích tuần {week_idx}:\n"
            f"- Trung bình giờ làm: {avg_hours:.2f} giờ\n"
            f"- Độ lệch chuẩn giờ: {std_hours:.2f}\n"
            f"- Tổng nhiệm vụ: {total_tasks}\n"
            f"- Thành viên xuất sắc: Thành viên {best_member + 1} ({best_tasks} nhiệm vụ)"
        )
    return "\n\n".join(results)

def advanced_analysis():
    if not os.path.exists(FILENAME):
        return "Không tìm thấy file dữ liệu.", None, None
    data = np.load(FILENAME).reshape(-1, 2)
    hours = data[:, 0]
    tasks = data[:, 1]
    slope, intercept, r_value, _, _ = stats.linregress(hours, tasks)
    corr, _ = stats.pearsonr(hours, tasks)
    mean_hr = np.mean(hours)
    std_hr = np.std(hours)
    outliers = hours[(hours < mean_hr - 2*std_hr) | (hours > mean_hr + 2*std_hr)]
    outliers = np.round(outliers, 2).tolist()
    result = (
        f"Hồi quy tuyến tính:\n"
        f"- Độ dốc: {slope:.4f}\n"
        f"- Hệ số tương quan: {corr:.4f}\n"
        f"- Giá trị ngoại lai (giờ làm): {outliers}"
    )
    return result, slope, intercept

def optimize_workload(slope, intercept, members=5):
    if slope is None:
        return "Chưa có dữ liệu hồi quy để tối ưu."

    def objective(x):
        return -(slope * np.sum(x) + intercept * members)

    constraints = [{'type': 'ineq', 'fun': lambda x: 200 - np.sum(x)}]
    bounds = [(30, None)] * members
    initial = [40] * members

    res = optimize.minimize(objective, initial, bounds=bounds, constraints=constraints)
    if res.success:
        return [round(x, 2) for x in res.x]
    else:
        return "Không thể tối ưu phân bổ giờ làm."

# ========================
# Giao diện Tkinter
# ========================

class WorkAnalysisApp:
    def __init__(self, master):
        self.master = master
        master.title("Phân tích hiệu suất nhóm dự án")
        master.geometry("650x600")
        master.resizable(False, False)

        self.text_area = scrolledtext.ScrolledText(master, wrap=tk.WORD, width=80, height=25)
        self.text_area.pack(padx=10, pady=10)

        btn_frame = tk.Frame(master)
        btn_frame.pack()

        tk.Button(btn_frame, text="Tạo dữ liệu", command=self.handle_create_data).grid(row=0, column=0, padx=5)
        tk.Button(btn_frame, text="Phân tích cơ bản", command=self.handle_basic_analysis).grid(row=0, column=1, padx=5)
        tk.Button(btn_frame, text="Phân tích nâng cao", command=self.handle_advanced_analysis).grid(row=0, column=2, padx=5)
        tk.Button(btn_frame, text="Tối ưu phân bổ", command=self.handle_optimize_workload).grid(row=0, column=3, padx=5)

        self.slope = None
        self.intercept = None

    def handle_create_data(self):
        result = create_performance_data()
        self.text_area.insert(tk.END, result + "\n\n")

    def handle_basic_analysis(self):
        result = basic_analysis()
        self.text_area.insert(tk.END, result + "\n\n")

    def handle_advanced_analysis(self):
        result, self.slope, self.intercept = advanced_analysis()
        self.text_area.insert(tk.END, result + "\n\n")

    def handle_optimize_workload(self):
        result = optimize_workload(self.slope, self.intercept)
        if isinstance(result, list):
            lines = [f"- Thành viên {i + 1}: {h} giờ" for i, h in enumerate(result)]
            self.text_area.insert(tk.END, "Phân bổ giờ làm tuần tới:\n" + "\n".join(lines) + "\n\n")
        else:
            self.text_area.insert(tk.END, result + "\n\n")

# ========================
# Chạy ứng dụng
# ========================
if __name__ == "__main__":
    root = tk.Tk()
    app = WorkAnalysisApp(root)
    root.mainloop()
