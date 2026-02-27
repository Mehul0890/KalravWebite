================================================
KALRAV VIDHYA MANDIR - SCHOOL WEBSITE
================================================
Technology: Pure PHP + MySQL (XAMPP)
Created for: Kalrav Vidhya Mandir, Gujarat, India

================================================
INSTALLATION STEPS
================================================

1. Copy the entire "kalrav" folder to:
   C:\xampp\htdocs\kalrav\

2. Start XAMPP (Apache + MySQL)

3. Open phpMyAdmin: http://localhost/phpmyadmin

4. Create database: kalrav_school

5. Import: http://localhost/phpmyadmin
   Select kalrav_school → Import → kalrav/database.sql

6. SET ADMIN PASSWORD:
   Open: http://localhost/kalrav/setup_password.php
   (This sets the correct password hash)
   
7. Access website: http://localhost/kalrav/

8. Admin panel: http://localhost/kalrav/admin/login.php

================================================
ADMIN CREDENTIALS
================================================

Username: @Kalrav550
Password: @Adminkalrav9900

================================================
FOLDER STRUCTURE
================================================

kalrav/
├── index.php          - Home page
├── about.php          - About page
├── academics.php      - Academics page
├── gallery.php        - Photo gallery
├── quiz.php           - Quiz page
├── notices.php        - Notice board
├── events.php         - Events page
├── admissions.php     - Admissions page
├── contact.php        - Contact page
├── quiz_data.php      - Quiz AJAX endpoint
├── setup_password.php - Run once to set password
├── database.sql       - Database file
│
├── includes/
│   ├── header.php     - Site header & nav
│   ├── footer.php     - Site footer
│   └── db.php         - Database connection
│
├── assets/
│   ├── css/style.css  - All styles
│   └── js/script.js   - JavaScript
│
├── uploads/
│   ├── gallery/       - Gallery images
│   └── banner/        - Banner images
│
└── admin/
    ├── login.php
    ├── dashboard.php
    ├── manage_banner.php
    ├── manage_gallery.php
    ├── manage_notices.php
    ├── manage_events.php
    ├── manage_quiz.php
    ├── manage_contact.php
    └── logout.php

================================================
FEATURES
================================================

PUBLIC WEBSITE:
✅ Dynamic banner slider (from DB)
✅ "Get a Call" button (admin editable form link)
✅ Notice board with pinned paper effect
✅ Interactive quiz system with score
✅ Photo gallery with category filtering
✅ Events with date display
✅ Admissions page with process steps
✅ Contact page with Google Map embed
✅ Fully responsive design
✅ Premium yellow & dark color scheme

ADMIN PANEL:
✅ Secure login with password_hash
✅ Session-based authentication
✅ Manage banners (add/delete/toggle/edit form link)
✅ Upload gallery images by category
✅ Add/pin/delete notices
✅ Add/delete events
✅ Create quizzes with multiple types
✅ Add questions to quizzes
✅ Edit all contact information

================================================
