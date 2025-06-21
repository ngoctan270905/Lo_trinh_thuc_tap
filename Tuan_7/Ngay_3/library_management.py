# library_management.py

class User:
    def __init__(self, ma_nguoi_dung, ten):
        self.__ma_nguoi_dung = ma_nguoi_dung
        self.ten = ten
        self.ds_muon = []

    def get_ma(self):
        return self.__ma_nguoi_dung

    def borrow_book(self, ma_sach):
        if ma_sach not in self.ds_muon:
            self.ds_muon.append(ma_sach)

    def return_book(self, ma_sach):
        if ma_sach in self.ds_muon:
            self.ds_muon.remove(ma_sach)

    def get_borrowed_books(self):
        return self.ds_muon


class Library:
    def __init__(self):
        self.sach = []

    def add_book(self, book):
        self.sach.append(book)

    def __iter__(self):
        self._i = 0
        return self

    def __next__(self):
        if self._i < len(self.sach):
            b = self.sach[self._i]
            self._i += 1
            return b
        raise StopIteration()
