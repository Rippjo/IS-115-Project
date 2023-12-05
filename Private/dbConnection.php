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
CREATE TABLE course (
    course_id INT AUTO_INCREMENT PRIMARY KEY,
    course_name VARCHAR(50)
);
CREATE TABLE time_slots (
    slot_id INT AUTO_INCREMENT PRIMARY KEY,
    teacher_id INT,
    course_id INT,
    day_of_week VARCHAR(20),
    start_time TIME,
    end_time TIME,
    FOREIGN KEY (teacher_id) REFERENCES user(user_id),
    FOREIGN KEY (course_id) REFERENCES course(course_id)
);

CREATE TABLE teacher_availability (
    availability_id INT AUTO_INCREMENT PRIMARY KEY,
    teacher_id INT,
    day_of_week VARCHAR(20),
    start_time TIME,
    end_time TIME,
    FOREIGN KEY (teacher_id) REFERENCES user(user_id)
);

CREATE TABLE student_booking (
    booking_id INT PRIMARY KEY AUTO_INCREMENT,
    teacher_id INT ,
    student_id INT,
    course_name VARCHAR(255),
    booking_date DATE,
    start_time TIME,
    end_time TIME,
    explanation TEXT,
    is_confirmed BOOLEAN
    FOREIGN KEY (teacher_id) REFERENCES user(user_id),
    FOREIGN KEY (student_id) REFERENCES user(user_id),
);

CREATE TABLE student_booking (
    booking_id INT PRIMARY KEY AUTO_INCREMENT,
    teacher_id INT,
    course_name VARCHAR(255),
    booking_date DATE,
    start_time TIME,
    end_time TIME

);

CREATE TABLE booked_slots (
    booking_id INT AUTO_INCREMENT PRIMARY KEY,
    teacher_id INT,
    course_id INT,
    booking_date DATE,
    start_time TIME,
    end_time TIME,
    FOREIGN KEY (booking_id) REFERENCES student_booking(booking_id),
    FOREIGN KEY (teacher_id) REFERENCES user(user_id),
    FOREIGN KEY (course_id) REFERENCES course(course_id)
);
