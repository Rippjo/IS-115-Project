<?php

class User {
    public $user_id;
    public $username;
    public $name;
    public $lastName;
    public $phone_number;
    public $email;
    public $password;
    public $user_type;
    public $registration_date;
    public $birth_date;

    public function __construct($name, $lastName, $phone_number, $email, $password, $user_type, $birth_date) {
        $this->name = $name;
        $this->lastName = $lastName;
        $this->username = $this->generateUsername();
        $this->phone_number = $phone_number;
        $this->password = $password;
        $this->user_type = $user_type;
        $this->birth_date = $birth_date;
        $this->registration_date = date("Y-m-d");

        if ($this->validateEmail($email)) {
            $this->email = $email;
        } else {
            throw new InvalidArgumentException("Invalid email format");
        }
    }

    public function validateEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    protected function generateUsername() {
        $nameLower = strtolower($this->name);
        $lastNameLower = strtolower($this->lastName);

        $nameInitials = substr($nameLower, 0, 2);
        $lastNameInitials = substr($lastNameLower, 0, 2);

        $username = $nameInitials . $lastNameInitials;

        $randomNumber = rand(100, 999);
        $username .= $randomNumber;

        return $username;
    }

    public function saveToDatabase() {
        require_once "../../../Private/dbConn.php";

        try {
            $sql = "INSERT INTO user (username, name, lastName, phone_number, email, password, user_type, registration_date, birth_date)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = $conn->prepare($sql);

            $stmt->bind_param('ssssssiss', $this->username, $this->name, $this->lastName, $this->phone_number, $this->email, $this->password, $this->user_type, $this->registration_date, $this->birth_date);

            $stmt->execute();

            $conn = null;

            return true;
        } catch(Exception $e) {
            return false;
        }
    }

    public function isStrongPassword($password) {
        $uppercaseCount = preg_match_all('/[A-Z]/', $password);
        $numberCount = preg_match_all('/[0-9]/', $password);

        if ($uppercaseCount >= 1 && $numberCount >= 2 && strlen($password) >= 6) {
            return true;
        } else {
            return false;
        }
    }
    // checks if the passwrod is strong from the function isStrongPassword
    public function hashPassword($password) {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    public function verifyPassword($inputPassword) {
        return password_verify($inputPassword, $this->password);
    }
}
// Student class inheriting from User and then overrides the generateUsername method to append 'S' for students
class Student extends User {
    protected function generateUsername() {
        $baseUsername = parent::generateUsername();
        return $baseUsername . 'S';
    }
}

// Teacher class inheriting from User and then overrides the generateUsername method to append 'T' for teachers
class Teacher extends User {
    protected function generateUsername() {
        $baseUsername = parent::generateUsername();
        return $baseUsername . 'T';
    }
}

?>

