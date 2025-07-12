

public class CurrentAccount extends BankAccount implements Printable {
    private final double overdraftLimit = 500.0;

    public CurrentAccount(String accountNumber, Person owner, double balance) {
        super(accountNumber, owner, balance, AccountType.CURRENT);
    }

    @Override
    public void withdraw(double amount) {
        if (amount <= 0 || amount > balance + overdraftLimit) {
            System.out.println("So tien vuot qua han muc cho phep.");
            return;
        }
        balance -= amount;
        transactions.add(new Transaction(TransactionType.WITHDRAW, amount));
        System.out.println("Rut tien thanh cong tu tai khoan thanh toan.");
    }

    @Override
    public void printSummary() {
        System.out.println("Thanh toan | " + owner.getFullName() + " | So TK: " + accountNumber + " | So du: " + balance);
    }
}

