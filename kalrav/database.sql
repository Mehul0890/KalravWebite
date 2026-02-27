-- Kalrav Vidhya Mandir Database
CREATE DATABASE IF NOT EXISTS kalrav_school CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE kalrav_school;

CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Password: @Adminkalrav9900 (hashed with password_hash)
INSERT INTO admins (username, password) VALUES 
('@Kalrav550', '$2y$10$R9h/cIPz0gi.URLV14RZlukoYFVAHPyrkEGv0MHVpZhMaHpFNBdW.');

CREATE TABLE IF NOT EXISTS banners (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255),
    subtitle VARCHAR(255),
    image_path VARCHAR(500),
    call_form_link VARCHAR(500) DEFAULT '',
    is_active TINYINT(1) DEFAULT 1,
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO banners (title, subtitle, image_path, call_form_link, is_active, sort_order) VALUES
('Welcome to Kalrav Vidhya Mandir', 'Nurturing Minds, Building Futures in Gujarat', '', 'https://forms.google.com/', 1, 1),
('Excellence in Education', 'Where Knowledge Meets Wisdom', '', 'https://forms.google.com/', 1, 2),
('Shaping Tomorrow Leaders', 'Quality Education Since Inception', '', 'https://forms.google.com/', 1, 3);

CREATE TABLE IF NOT EXISTS gallery (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255),
    category ENUM('Indian Festivals','Other Activities','Annual Day') DEFAULT 'Other Activities',
    year VARCHAR(10) DEFAULT NULL,
    image_path VARCHAR(500),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO gallery (title, category, year, image_path) VALUES
('Diwali Celebration 2024', 'Indian Festivals', '2024', ''),
('Holi Festival 2024', 'Indian Festivals', '2024', ''),
('Republic Day', 'Indian Festivals', '2024', ''),
('Independence Day', 'Indian Festivals', '2024', ''),
('Science Exhibition', 'Other Activities', '2024', ''),
('Sports Day', 'Other Activities', '2024', ''),
('Yoga Day', 'Other Activities', '2024', ''),
('Annual Day 2024', 'Annual Day', '2024', ''),
('Annual Day 2023', 'Annual Day', '2023', ''),
('Annual Day 2022', 'Annual Day', '2022', '');

CREATE TABLE IF NOT EXISTS notices (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT,
    is_pinned TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO notices (title, content, is_pinned) VALUES
('Admission Open 2025-26', 'Admissions are now open for the academic year 2025-26. Contact the school office for details. Limited seats available.', 1),
('Annual Day Celebration', 'Annual Day will be celebrated on 15th March 2025. All parents are cordially invited.', 1),
('Holiday Notice - Holi', 'School will remain closed on 25th March 2025 on account of Holi festival.', 0),
('PTM Schedule', 'Parent Teacher Meeting scheduled for 1st February 2025. Please ensure attendance.', 0),
('Exam Timetable Released', 'Final exam timetable for Std 1-12 has been released. Check school notice board.', 0),
('New Computer Lab', 'We are pleased to announce the opening of our new state-of-the-art computer lab.', 0);

CREATE TABLE IF NOT EXISTS quizzes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    quiz_type ENUM('Multiple Choice','Picture Quiz','Matching Quiz','Vocabulary Quiz','True/False','Video Quiz','Quiz Competition') DEFAULT 'Multiple Choice',
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO quizzes (title, description, quiz_type, is_active) VALUES
('General Knowledge Quiz', 'Test your general knowledge about India and the world.', 'Multiple Choice', 1),
('Science & Nature', 'Quiz about science facts and nature.', 'Multiple Choice', 1),
('True or False Challenge', 'Can you tell fact from fiction?', 'True/False', 1),
('Vocabulary Builder', 'Improve your English vocabulary.', 'Vocabulary Quiz', 1);

CREATE TABLE IF NOT EXISTS quiz_questions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    quiz_id INT NOT NULL,
    question TEXT NOT NULL,
    option_a VARCHAR(255),
    option_b VARCHAR(255),
    option_c VARCHAR(255),
    option_d VARCHAR(255),
    correct_answer ENUM('A','B','C','D') DEFAULT 'A',
    image_path VARCHAR(500) DEFAULT NULL,
    video_url VARCHAR(500) DEFAULT NULL,
    FOREIGN KEY (quiz_id) REFERENCES quizzes(id) ON DELETE CASCADE
);

INSERT INTO quiz_questions (quiz_id, question, option_a, option_b, option_c, option_d, correct_answer) VALUES
(1, 'What is the capital of India?', 'Mumbai', 'New Delhi', 'Kolkata', 'Chennai', 'B'),
(1, 'How many states are in India?', '25', '27', '28', '29', 'C'),
(1, 'Which river flows through Ahmedabad?', 'Sabarmati', 'Narmada', 'Tapti', 'Mahi', 'A'),
(1, 'Who is known as the Father of the Nation?', 'Jawaharlal Nehru', 'Subhas Chandra Bose', 'Mahatma Gandhi', 'Bhagat Singh', 'C'),
(2, 'What is the chemical symbol for water?', 'O2', 'H2O', 'CO2', 'HO', 'B'),
(2, 'How many planets are in our solar system?', '7', '8', '9', '10', 'B'),
(2, 'What gas do plants absorb from the atmosphere?', 'Oxygen', 'Nitrogen', 'Carbon Dioxide', 'Hydrogen', 'C'),
(3, 'The Great Wall of China is visible from space.', 'True', 'False', NULL, NULL, 'B'),
(3, 'India has the largest population in the world (2024).', 'True', 'False', NULL, NULL, 'A'),
(3, 'The Sun is a planet.', 'True', 'False', NULL, NULL, 'B'),
(4, 'What is the synonym of Happy?', 'Sad', 'Angry', 'Joyful', 'Tired', 'C'),
(4, 'What is the antonym of Hot?', 'Warm', 'Cool', 'Cold', 'Humid', 'C'),
(4, 'What is the synonym of Brave?', 'Coward', 'Fearful', 'Courageous', 'Timid', 'C');

CREATE TABLE IF NOT EXISTS events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    event_date DATE,
    image_path VARCHAR(500) DEFAULT '',
    is_featured TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO events (title, description, event_date, is_featured) VALUES
('Annual Day 2025', 'A grand celebration of talent and achievement. Cultural programs, prize distribution and more.', '2025-03-15', 1),
('Science Exhibition', 'Students showcase innovative science projects. Open to all parents and guests.', '2025-02-20', 1),
('Sports Week', 'Week-long sports events including cricket, kabaddi, kho-kho, and athletics.', '2025-01-10', 0),
('Diwali Celebration', 'School Diwali celebration with rangoli, diyas and cultural performances.', '2024-11-01', 0),
('Republic Day', 'Republic Day celebration with flag hoisting, march past and speeches.', '2025-01-26', 1),
('Yoga Day', 'International Yoga Day celebration with mass yoga session.', '2025-06-21', 0);

CREATE TABLE IF NOT EXISTS contact_info (
    id INT AUTO_INCREMENT PRIMARY KEY,
    school_name VARCHAR(255) DEFAULT 'Kalrav Vidhya Mandir',
    address TEXT,
    phone VARCHAR(50),
    email VARCHAR(100),
    google_map_embed TEXT,
    facebook_url VARCHAR(500) DEFAULT '',
    instagram_url VARCHAR(500) DEFAULT '',
    youtube_url VARCHAR(500) DEFAULT '',
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO contact_info (school_name, address, phone, email, google_map_embed) VALUES
('Kalrav Vidhya Mandir',
'Kalrav Vidhya Mandir, Near Water Tank, Ahmedabad, Gujarat - 380001, India',
'+91 79 1234 5678',
'info@kalravvidyamandir.edu.in',
'<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3671.9023999999997!2d72.57139999999999!3d23.022499999999997!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMjPCsDAxJzIxLjAiTiA3MsKwMzQnMTcuMCJF!5e0!3m2!1sen!2sin!4v1234567890" width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>');

-- ================================================
-- IMPORTANT: After importing this SQL file, run:
-- http://localhost/kalrav/setup_password.php
-- This will properly set the admin password hash.
-- Username: @Kalrav550
-- Password: @Adminkalrav9900
-- ================================================
