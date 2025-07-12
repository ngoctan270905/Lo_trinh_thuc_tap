public class Student {
    private static int autoId = 1;

    int id;
    String name;
    int age;
    double score;

    public Student(String name, int age, double score) {
        this.id = autoId++;
        this.name = name;
        this.age = age;
        this.score = score;
    }

    public void printStudent() {
        System.out.printf("ID: %d | Tên: %s | Tuổi: %d | Điểm: %.2f\n", id, name, age, score);
    }

    public void printStudent(boolean showId) {
        if (showId) printStudent();
        else System.out.printf("Tên: %s | Tuổi: %d | Điểm: %.2f\n", name, age, score);
    }
}
