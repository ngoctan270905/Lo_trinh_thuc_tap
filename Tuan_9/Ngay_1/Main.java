import java.util.ArrayList;
import java.util.Collections;
import java.util.Comparator;
import java.util.Scanner;

public class Main {
    static ArrayList<Student> students = new ArrayList<>();
    static Scanner scanner = new Scanner(System.in);

    public static void main(String[] args) {
        int choice;

        do {
            showMenu();
            choice = Integer.parseInt(scanner.nextLine());

            switch (choice) {
                case 1 -> addStudent();
                case 2 -> showStudents();
                case 3 -> searchByName();
                case 4 -> findTopScoreStudent();
                case 5 -> sortByScoreDescending();
                case 6 -> calculateAverageScore();
                case 7 -> factorialOfFirstStudentAge();
                case 0 -> System.out.println("Thoat chuong trinh.");
                default -> System.out.println("Lua chon khong hop le.");
            }
        } while (choice != 0);
    }

    static void showMenu() {
        System.out.println("\n===== MENU =====");
        System.out.println("1. Them sinh vien");
        System.out.println("2. Hien thi danh sach sinh vien");
        System.out.println("3. Tim sinh vien theo ten");
        System.out.println("4. Tim sinh vien co diem cao nhat");
        System.out.println("5. Sap xep theo diem giam dan");
        System.out.println("6. Tinh diem trung binh");
        System.out.println("7. Giai thua tuoi sinh vien dau tien");
        System.out.println("0. Thoat");
        System.out.print("Chon: ");
    }

    static void addStudent() {
        System.out.print("Nhap ten: ");
        String name = scanner.nextLine();

        int age;
        do {
            System.out.print("Nhap tuoi (>0): ");
            age = Integer.parseInt(scanner.nextLine());
        } while (age <= 0);

        double score;
        do {
            System.out.print("Nhap diem (0-10): ");
            score = Double.parseDouble(scanner.nextLine());
        } while (score < 0 || score > 10);

        students.add(new Student(name, age, score));
        System.out.println("Da them sinh vien.");
    }

    static void showStudents() {
        if (students.isEmpty()) {
            System.out.println("Danh sach trong.");
            return;
        }

        System.out.println("Danh sach sinh vien:");
        for (Student s : students) {
            s.printStudent();
        }
    }

    static void searchByName() {
        System.out.print("Nhap ten can tim: ");
        String keyword = scanner.nextLine().toLowerCase();
        boolean found = false;

        for (Student s : students) {
            if (s.name.toLowerCase().contains(keyword)) {
                s.printStudent();
                found = true;
            }
        }

        if (!found) System.out.println("Khong tim thay sinh vien nao.");
    }

    static void findTopScoreStudent() {
        if (students.isEmpty()) {
            System.out.println("Danh sach trong.");
            return;
        }

        Student top = Collections.max(students, Comparator.comparingDouble(s -> s.score));
        System.out.println("Sinh vien co diem cao nhat:");
        top.printStudent();
    }

    static void sortByScoreDescending() {
        students.sort((s1, s2) -> Double.compare(s2.score, s1.score));
        System.out.println("Da sap xep theo diem giam dan.");
    }

    static void calculateAverageScore() {
        if (students.isEmpty()) {
            System.out.println("Danh sach trong.");
            return;
        }

        double sum = 0;
        for (Student s : students) {
            sum += s.score;
        }

        System.out.printf("Diem trung binh: %.2f\n", sum / students.size());
    }

    static void factorialOfFirstStudentAge() {
        if (students.isEmpty()) {
            System.out.println("Danh sach trong.");
            return;
        }

        int age = students.get(0).age;
        long result = factorial(age);
        System.out.printf("Giai thua tuoi %d la: %d\n", age, result);
    }

    static long factorial(int n) {
        if (n <= 1) return 1;
        return n * factorial(n - 1); // recursion
    }
}
