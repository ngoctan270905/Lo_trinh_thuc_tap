import java.time.LocalDate;
import java.time.LocalDateTime;
import java.util.ArrayList;
import java.util.List;

public abstract class BankAccount {
    protected String accountNumber;
    protected Person owner;
    protected double balance;
    protected LocalDate createdDate;
    protected AccountType type;
    protected List<Transaction> transactions = new ArrayList<>();

    public BankAccount(String accountNumber, Person owner, double balance, AccountType type) {
        this.accountNumber = accountNumber;
        this.owner = owner;
        this.balance = balance;
        this.createdDate = LocalDate.now();
        this.type = type;
    }

    public void deposit(double amount) {
        if (amount <= 0) {
            System.out.println("So tien khong hop le.");
            return;
        }
        balance += amount;
        transactions.add(new Transaction(TransactionType.DEPOSIT, amount));
        System.out.println("Da gui tien thanh cong.");
    }

    public abstract void withdraw(double amount);

    public double getBalance() {
        return balance;
    }

    public String getAccountNumber() {
        return accountNumber;
    }

    public void printAccountInfo() {
        System.out.println("\n--- Thong tin tai khoan ---");
        System.out.println("Chu tai khoan: " + owner.getFullName());
        System.out.println("So tai khoan: " + accountNumber);
        System.out.println("Loai: " + type);
        System.out.println("So du: " + balance);
        System.out.println("Ngay tao: " + createdDate);
        System.out.println("Lich su giao dich:");
        for (Transaction t : transactions) {
            System.out.println(" - " + t);
        }
    }

    // Inner class Transaction
    protected class Transaction {
        private String id;
        private TransactionType type;
        private double amount;
        private LocalDateTime timestamp;

        public Transaction(TransactionType type, double amount) {
            this.id = "TX-" + System.nanoTime();
            this.type = type;
            this.amount = amount;
            this.timestamp = LocalDateTime.now();
        }

        @Override
        public String toString() {
            return "[" + timestamp + "] " + type + " $" + amount;
        }
    }
}

