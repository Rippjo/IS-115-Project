<?php
//User class with username, name, lastname, birthdate, and registration date as variables, will have underclasses (Student/Teacher)
class User {
    protected $userName;
    protected $name;
    protected $lastName;
    protected $birthDate;
    protected $regDate;


    public function __construct($userName, $name, $lastName, $birthDate, $regDate) {
         $this->userName = $userName;
         $this->name = $name;
         $this->lastName = $lastName;
         $this->birthDate = $birthDate;
         $this->regDate = $regDate;
    }

    Public function getUserName() {
        return $this->userName;

    }

    Public function getName() {
        return $this->name;

    }

    Public function getLastName() {
        return $this->lastName;

    }

    Public function getBirthDate() {
        return $this->birthDate;

    }

    Public function getRegDate() {
        return $this->regDate;

    }

    //Class method to calculate the age, can be used to present age in profile for example.
    public function calcAge() {
        $birthDate = new DateTime($this->birthDate);
        $now = new DateTime();
        $age = $now->diff($birthDate)->y;
        return $age;
    }
    
    
} 

?>