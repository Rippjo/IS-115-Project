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
    username varchar(15)
);
