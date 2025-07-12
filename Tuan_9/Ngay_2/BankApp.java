import java.util.*;
public class BankApp {
    private static ArrayList<BankAccount> accounts = new ArrayList<>();
    private static Scanner scanner = new Scanner(System.in);

    public static void main(String[] args) {
        while (true) {
            System.out.println("\n===== MENU NGÂN HÀNG =====");
            System.out.println("1. Tạo tài khoản mới");
            System.out.println("2. Gửi tiền");
            System.out.println("3. Rút tiền");
            System.out.println("4. Xem số dư");
            System.out.println("5. Xem lịch sử giao dịch");
            System.out.println("6. In thông tin tài khoản");
            System.out.println("0. Thoát");
            System.out.print("Chọn chức năng: ");
            int choice = Integer.parseInt(scanner.nextLine());

            switch (choice) {
                case 1: createAccount(); break;
                case 2: deposit(); break;
                case 3: withdraw(); break;
                case 4: checkBalance(); break;
                case 5: printTransactions(); break;
                case 6: printAccountSummary(); break;
                case 0: System.exit(0);
                default: System.out.println("Lựa chọn không hợp lệ!");
            }
        }
    }

    private static void createAccount() {
        System.out.print("Nhập ID khách hàng: ");
        String id = scanner.nextLine();
        System.out.print("Nhập họ tên: ");
        String name = scanner.nextLine();
        System.out.print("Nhập email: ");
        String email = scanner.nextLine();
        System.out.print("Nhập số điện thoại: ");
        String phone = scanner.nextLine();
        Person owner = new Person(id, name, email, phone);

        System.out.print("Nhập số tài khoản: ");
        String accNum = scanner.nextLine();
        System.out.print("Chọn loại tài khoản (1-Tiết kiệm, 2-Thanh toán): ");
        int type = Integer.parseInt(scanner.nextLine());
        System.out.print("Nhập số dư ban đầu: ");
        double balance = Double.parseDouble(scanner.nextLine());

        BankAccount acc;
        if (type == 1) {
            acc = new SavingsAccount(accNum, owner, balance);
        } else {
            acc = new CurrentAccount(accNum, owner, balance);
        }
        accounts.add(acc);
        System.out.println("Tạo tài khoản thành công!");
    }

    private static BankAccount findAccount() {
        System.out.print("Nhập số tài khoản: ");
        String accNum = scanner.nextLine();
        for (BankAccount acc : accounts) {
            if (acc.getAccountNumber().equals(accNum)) return acc;
        }
        System.out.println("Không tìm thấy tài khoản!");
        return null;
    }

    private static void deposit() {
        BankAccount acc = findAccount();
        if (acc == null) return;
        System.out.print("Nhập số tiền gửi: ");
        double amount = Double.parseDouble(scanner.nextLine());
        acc.deposit(amount);
    }

    private static void withdraw() {
        BankAccount acc = findAccount();
        if (acc == null) return;
        System.out.print("Nhập số tiền rút: ");
        double amount = Double.parseDouble(scanner.nextLine());
        acc.withdraw(amount);
    }

    private static void checkBalance() {
        BankAccount acc = findAccount();
        if (acc == null) return;
        System.out.println("Số dư: " + acc.getBalance());
    }

    private static void printTransactions() {
        BankAccount acc = findAccount();
        if (acc == null) return;
        acc.printAccountInfo();
    }

    private static void printAccountSummary() {
        BankAccount acc = findAccount();
        if (acc == null) return;
        if (acc instanceof Printable) {
            ((Printable) acc).printSummary();
        }
    }
} 