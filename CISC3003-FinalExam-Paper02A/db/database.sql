CREATE DATABASE IF NOT EXISTS cisc3003_p2a_dc227126 CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE cisc3003_p2a_dc227126;
CREATE TABLE IF NOT EXISTS scenario_a_submissions(id INT AUTO_INCREMENT PRIMARY KEY,full_name VARCHAR(80) NOT NULL,email VARCHAR(120) NOT NULL,student_id VARCHAR(20) NOT NULL,message TEXT NOT NULL,topic VARCHAR(80) NOT NULL,study_mode VARCHAR(40) NOT NULL,skills VARCHAR(255),created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP);
INSERT INTO scenario_a_submissions(full_name,email,student_id,message,topic,study_mode,skills) VALUES('SITINIEK','dc227126@um.edu.mo','DC227126','Sample SQL INSERT INTO record.','Prepared Statements','Individual','HTML, PHP, MySQL');
