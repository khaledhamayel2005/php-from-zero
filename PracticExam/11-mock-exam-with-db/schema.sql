CREATE DATABASE IF NOT EXISTS webTest;
USE webTest;

CREATE TABLE IF NOT EXISTS practice_members (
  userid VARCHAR(40) PRIMARY KEY,
  userpassword VARCHAR(100) NOT NULL,
  fullname VARCHAR(100) NOT NULL,
  role VARCHAR(30) NOT NULL
);

CREATE TABLE IF NOT EXISTS practice_courses (
  course_id INT AUTO_INCREMENT PRIMARY KEY,
  code VARCHAR(20) NOT NULL UNIQUE,
  title VARCHAR(100) NOT NULL,
  credits INT NOT NULL
);

CREATE TABLE IF NOT EXISTS practice_registrations (
  id INT AUTO_INCREMENT PRIMARY KEY,
  userid VARCHAR(40) NOT NULL,
  course_id INT NOT NULL,
  registered_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT IGNORE INTO practice_members (userid, userpassword, fullname, role) VALUES
('student', md5('1234'), 'Practice Student', 'Student'),
('manager', md5('admin'), 'Practice Manager', 'Manager');

INSERT IGNORE INTO practice_courses (code, title, credits) VALUES
('COMP231', 'Web Programming', 3),
('COMP232', 'Web Lab', 1),
('COMP240', 'Database', 3),
('COMP241', 'Database Lab', 1);
