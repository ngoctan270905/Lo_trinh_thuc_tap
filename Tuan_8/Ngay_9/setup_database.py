import mysql.connector
from mysql.connector import errorcode

def setup_database():
    try:
        # Kết nối tới MySQL
        conn = mysql.connector.connect(
            host="localhost",
            user="root",
            password="",  # đổi nếu cần
        )
        cursor = conn.cursor()

        # Tạo database nếu chưa có
        cursor.execute("CREATE DATABASE IF NOT EXISTS project_progress")
        cursor.execute("USE project_progress")

        # Tạo bảng members
        cursor.execute("""
        CREATE TABLE IF NOT EXISTS members (
            member_id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100),
            role VARCHAR(50)
        )
        """)

        # Tạo bảng weekly_progress
        cursor.execute("""
        CREATE TABLE IF NOT EXISTS weekly_progress (
            progress_id INT AUTO_INCREMENT PRIMARY KEY,
            member_id INT,
            week_number INT,
            hours_worked FLOAT CHECK (hours_worked >= 0),
            tasks_completed INT,
            notes TEXT,
            FOREIGN KEY (member_id) REFERENCES members(member_id)
        )
        """)

        print("✅ Cơ sở dữ liệu và bảng đã được tạo thành công.")

        # ======= THÊM DỮ LIỆU MẪU =======
        # Thêm thành viên nếu chưa có
        cursor.execute("SELECT COUNT(*) FROM members")
        member_count = cursor.fetchone()[0]

        if member_count == 0:
            members = [
                ("An", "Developer"),
                ("Bình", "Tester"),
                ("Cường", "Designer"),
                ("Duyên", "Manager"),
                ("Em", "Developer")
            ]
            cursor.executemany("INSERT INTO members (name, role) VALUES (%s, %s)", members)
            conn.commit()
            print("✅ Đã thêm dữ liệu thành viên mẫu.")

        # Lấy ID các thành viên
        cursor.execute("SELECT member_id FROM members")
        member_ids = [row[0] for row in cursor.fetchall()]

        # Thêm dữ liệu tiến độ nếu chưa có
        cursor.execute("SELECT COUNT(*) FROM weekly_progress")
        progress_count = cursor.fetchone()[0]

        if progress_count == 0 and len(member_ids) >= 5:
            progress_data = [
                (member_ids[0], 1, 40.5, 5, "Hoàn thành các module chính."),
                (member_ids[1], 1, 38.0, 4, "Kiểm thử tính năng."),
                (member_ids[2], 1, 42.0, 6, "Thiết kế UI."),
                (member_ids[3], 1, 39.5, 5, "Điều phối team."),
                (member_ids[4], 1, 41.0, 5, "Hỗ trợ triển khai."),
                (member_ids[0], 2, 40.0, 6, "Tối ưu mã."),
                (member_ids[1], 2, 37.5, 3, "Viết test case."),
                (member_ids[2], 2, 43.0, 7, "Thiết kế banner."),
                (member_ids[3], 2, 39.0, 4, "Tổ chức họp nhóm."),
                (member_ids[4], 2, 40.5, 5, "Viết tài liệu.")
            ]
            cursor.executemany("""
                INSERT INTO weekly_progress (member_id, week_number, hours_worked, tasks_completed, notes)
                VALUES (%s, %s, %s, %s, %s)
            """, progress_data)
            conn.commit()
            print("✅ Đã thêm dữ liệu tiến độ mẫu cho tuần 1 và 2.")

        cursor.close()
        conn.close()

    except mysql.connector.Error as err:
        print("❌ Lỗi MySQL:", err)

if __name__ == "__main__":
    setup_database()
