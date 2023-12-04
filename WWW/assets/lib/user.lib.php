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

    // Constructor
    public function __construct($name, $lastName, $phone_number, $email, $password, $user_type, $birth_date) {
        $this->name = $name;
        $this->lastName = $lastName;
        $this->username = $this->generateUsername();
        $this->phone_number = $phone_number;
        $this->password = $password;
        $this->user_type = $user_type;
        $this->birth_date = $birth_date;
        $this->registration_date = date("Y-m-d");
        // Validate email
     if ($this->validateEmail($email)) {
        $this->email = $email;
    } else {
        throw new InvalidArgumentException("Invalid email format");
    }

}
    //method for generating a semi-random username
    private function generateUsername() {
        // makes sure username is lowercase
        $nameLower = strtolower($this->name);
        $lastNameLower = strtolower($this->lastName);
    
        // The first 2 letters of first and last name
        $nameInitials = substr($nameLower, 0, 2);
        $lastNameInitials = substr($lastNameLower, 0, 2);
    
        //puts the 2 first letters of first and last names together
        $username = $nameInitials . $lastNameInitials;
    
        // adds a random 3 digit number to username
        $randomNumber = rand(100, 999);
        $username .= $randomNumber;
    
        return $username;
    }

    //method for email validation
    public function validateEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    } 

    public function saveToDatabase() {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "project";

        try {
            // Create a connection to the database
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            
            // Set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Prepare the SQL statement for inserting data into the database
            $stmt = $conn->prepare("INSERT INTO user (username, name, lastName, phone_number, email, password, user_type, registration_date, birth_date)
                                    VALUES (:username, :name, :lastName, :phone_number, :email, :password, :user_type, :registration_date, :birth_date)");

            // Bind parameters to the prepared statement
            $stmt->bindParam(':username', $this->username);
            $stmt->bindParam(':name', $this->name);
            $stmt->bindParam(':lastName', $this->lastName);
            $stmt->bindParam(':phone_number', $this->phone_number);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':password', $this->password);
            $stmt->bindParam(':user_type', $this->user_type);
            $stmt->bindParam(':registration_date', $this->registration_date);
            $stmt->bindParam(':birth_date', $this->birth_date);

            // Execute the prepared statement
            $stmt->execute();

            // Close the database connection
            $conn = null;

            return true; // Successfully saved to the database
        } catch(PDOException $e) {
            // Handle database errors here
            // You might want to log the error or return a specific error message
            return false; // Failed to save to the database
        }
    }
    public function isStrongPassword($password) {
        // Check if the password meets the specified criteria
        $uppercaseCount = preg_match_all('/[A-Z]/', $password); // Count uppercase letters
        $numberCount = preg_match_all('/[0-9]/', $password); // Count numbers

        // Password should have at least 1 uppercase letter, 2 numbers, and be at least 6 characters long
        if ($uppercaseCount >= 1 && $numberCount >= 2 && strlen($password) >= 6) {
            return true; // Password meets the criteria
        } else {
            return false; // Password doesn't meet the criteria
        }
    }
    public function hashPassword($password) {
        // Hash the provided password using PHP's password_hash function
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    public function verifyPassword($inputPassword) {
        // Verify if the input password matches the hashed password using password_verify
        return password_verify($inputPassword, $this->password);
    }

}
?>