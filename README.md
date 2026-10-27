# Employee Leave Management System (ELMS)

Web-based leave management for employees and administrators.
Stack: PHP 8.1+, MySQL, Bootstrap 5, jQuery, XAMPP. Built with Agile (Scrum-style sprints).

## Run locally (XAMPP)
1. Copy this folder to `C:\xampp\htdocs\elms` and start **Apache** and **MySQL** in XAMPP.
2. Open phpMyAdmin -> **Import** -> choose `database/schema.sql`.
3. In a terminal, from the project folder: `C:\xampp\php\php.exe database\seed.php`
4. Visit http://localhost/elms/

| Role     | Email            | Password     |
|----------|------------------|--------------|
| Admin    | admin@elms.test  | Admin@12345  |
| Employee | emp@elms.test    | Employee@123 |

## Sprint progress
| Sprint | Goal | Status |
|--------|------|--------|
| 1 | Foundation, database, authentication, role dashboards | Done |
| 2 | Department and leave type management | Planned |
| 3 | Employee management, profile, change password | Planned |
| 4 | Leave application and leave history (employee) | Planned |
| 5 | Leave processing and admin dashboard (admin) | Planned |
| 6 | Integration, validation rules, UI polish | Planned |
| 7 | Testing, security hardening, deployment, docs | Planned |
