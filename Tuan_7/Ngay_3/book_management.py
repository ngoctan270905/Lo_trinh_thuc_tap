# book_management.py

class Book:
    def __init__(self, ma_sach, tieu_de, tac_gia, ton_kho):
        self.__ma_sach = ma_sach
        self.tieu_de = tieu_de
        self.tac_gia = tac_gia
        self.ton_kho = ton_kho

    def get_ma_sach(self):
        return self.__ma_sach

    def get_info(self):
        return f"{self.tieu_de} - {self.tac_gia} (Tồn: {self.ton_kho})"

    def update_stock(self, so_luong):
        if so_luong >= 0:
            self.ton_kho = so_luong

class PhysicalBook(Book):
    def __init__(self, ma_sach, tieu_de, tac_gia, ton_kho, trang_thai):
        super().__init__(ma_sach, tieu_de, tac_gia, ton_kho)
        self.trang_thai = trang_thai

    def get_info(self):
        return f"[Giấy] {super().get_info()} - Trạng thái: {self.trang_thai}"

class EBook(Book):
    def __init__(self, ma_sach, tieu_de, tac_gia, ton_kho, dinh_dang):
        super().__init__(ma_sach, tieu_de, tac_gia, ton_kho)
        self.dinh_dang = dinh_dang

    def get_info(self):
        return f"[EBook] {super().get_info()} - Định dạng: {self.dinh_dang}"
