

public class SavingsAccount extends BankAccount implements Printable {
    private double interestRate = 0.02;

    public SavingsAccount(String accountNumber, Person owner, double balance) {
        super(accountNumber, owner, balance, AccountType.SAVINGS);
    }

    @Override
    public void withdraw(double amount) {
        if (amount <= 0 || amount > balance) {
            System.out.println("So tien rut khong hop le.");
            return;
        }
        balance -= amount;
        transactions.add(new Transaction(TransactionType.WITHDRAW, amount));
        System.out.println("Rut tien thanh cong tu tai khoan tiet kiem.");
    }

    @Override
    public void printSummary() {
        System.out.println("Tiet kiem | " + owner.getFullName() + " | So TK: " + accountNumber + " | So du: " + balance);
    }
}

