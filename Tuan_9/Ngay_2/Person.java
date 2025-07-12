

/**
 * Lớp Person đại diện cho khách hàng ngân hàng
 * Thuộc tính: id, fullName, email, phoneNumber
 * Bao đóng với getter/setter
 */
public class Person {
    private String id;
    private String fullName;
    private String email;
    private String phoneNumber;

    public Person(String id, String fullName, String email, String phoneNumber) {
        this.id = id;
        this.fullName = fullName;
        this.email = email;
        this.phoneNumber = phoneNumber;
    }

    public String getId() {
        return id;
    }

    public String getFullName() {
        return fullName;
    }

    public String getEmail() {
        return email;
    }

    public String getPhoneNumber() {
        return phoneNumber;
    }

    public void setFullName(String fullName) {
        this.fullName = fullName;
    }

    public void setEmail(String email) {
        this.email = email;
    }

    public void setPhoneNumber(String phoneNumber) {
        this.phoneNumber = phoneNumber;
    }
}

