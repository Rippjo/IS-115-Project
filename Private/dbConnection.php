DBname: project

CREATE TABLE user (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    phone_number VARCHAR(20),
    email VARCHAR(255),
    password VARCHAR(255),
    user_type INT,
    registration_date DATE,
    birth_date DATE,
    username varchar(15),
    lastname varchar(30)
);

CREATE TABLE profile (
    profile_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    experience TEXT,
    courses_offer TEXT,
    tutoring_length TEXT,
    availability TEXT,
    topics_offered TEXT,
    FOREIGN KEY (user_id) REFERENCES user(user_id)
);
