CREATE TABLE student (
    studentID int(100) NOT NULL AUTO_INCREMENT,
    name varchar(50) NOT NULL,
    email varchar(30) NOT NULL,
    PRIMARY KEY (studentID)
);

INSERT INTO student (name, email) VALUES
('Luong Tung', 'tung@gmail.com'),
('Luong Hai', 'hai@gmail.com'),
('Minh Hieu', 'hieu@gmail.com');