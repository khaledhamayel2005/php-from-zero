CREATE DATABASE IF NOT EXISTS webTest;
USE webTest;

CREATE TABLE IF NOT EXISTS practice_users (
  usernumber INT AUTO_INCREMENT PRIMARY KEY,
  userid VARCHAR(40) NOT NULL UNIQUE,
  userpassword VARCHAR(100) NOT NULL,
  fullname VARCHAR(100) NOT NULL,
  role VARCHAR(30) NOT NULL
);

INSERT IGNORE INTO practice_users (userid, userpassword, fullname, role)
VALUES ('student', md5('1234'), 'Practice Student', 'Student');
