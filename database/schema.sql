CREATE DATABASE IF NOT EXISTS elms_db
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE elms_db;

CREATE TABLE users (
  id            INT UNSIGNED NOT NULL AUTO_INCREMENT,
  full_name     VARCHAR(150) NOT NULL,
  email         VARCHAR(190) NOT NULL,
  password_hash VARCHAR(255) NOT NULL,
  role          ENUM('admin','employee') NOT NULL DEFAULT 'employee',
  status        TINYINT(1) NOT NULL DEFAULT 1,            
  created_at    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY uq_users_email (email)
) ENGINE=InnoDB;

CREATE TABLE departments (
  id         INT UNSIGNED NOT NULL AUTO_INCREMENT,
  name       VARCHAR(150) NOT NULL,
  short_name VARCHAR(50)  NOT NULL,
  code       VARCHAR(50)  NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY uq_departments_name (name),
  UNIQUE KEY uq_departments_code (code)
) ENGINE=InnoDB;

CREATE TABLE leave_types (
  id          INT UNSIGNED NOT NULL AUTO_INCREMENT,
  name        VARCHAR(150) NOT NULL,
  description TEXT NULL,
  max_days    SMALLINT UNSIGNED NOT NULL DEFAULT 0,        
  created_at  TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY uq_leave_types_name (name)
) ENGINE=InnoDB;

CREATE TABLE employees (
  id            INT UNSIGNED NOT NULL AUTO_INCREMENT,
  user_id       INT UNSIGNED NOT NULL,
  emp_code      VARCHAR(50)  NOT NULL,
  department_id INT UNSIGNED NULL,
  gender        ENUM('Male','Female','Other') NULL,
  dob           DATE NULL,
  phone         VARCHAR(20) NULL,
  address       VARCHAR(255) NULL,
  city          VARCHAR(100) NULL,
  country       VARCHAR(100) NULL,
  created_at    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY uq_employees_user (user_id),
  UNIQUE KEY uq_employees_code (emp_code),
  CONSTRAINT fk_emp_user FOREIGN KEY (user_id)
    REFERENCES users(id) ON DELETE CASCADE,
  CONSTRAINT fk_emp_dept FOREIGN KEY (department_id)
    REFERENCES departments(id) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE leave_applications (
  id            INT UNSIGNED NOT NULL AUTO_INCREMENT,
  employee_id   INT UNSIGNED NOT NULL,
  leave_type_id INT UNSIGNED NOT NULL,
  from_date     DATE NOT NULL,
  to_date       DATE NOT NULL,
  reason        TEXT NOT NULL,
  status        ENUM('pending','approved','declined') NOT NULL DEFAULT 'pending',
  admin_remark  TEXT NULL,
  reviewed_by   INT UNSIGNED NULL,
  reviewed_at   DATETIME NULL,
  created_at    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  KEY idx_leave_employee (employee_id),
  KEY idx_leave_status (status),
  CONSTRAINT fk_leave_emp  FOREIGN KEY (employee_id)   REFERENCES employees(id)   ON DELETE CASCADE,
  CONSTRAINT fk_leave_type FOREIGN KEY (leave_type_id) REFERENCES leave_types(id)  ON DELETE RESTRICT,
  CONSTRAINT fk_leave_by   FOREIGN KEY (reviewed_by)   REFERENCES users(id)        ON DELETE SET NULL,
  CONSTRAINT chk_leave_dates CHECK (to_date >= from_date)
) ENGINE=InnoDB;

INSERT INTO departments (name, short_name, code) VALUES
  ('Human Resources','HR','HR100'),
  ('Information Technology','IT','IT200'),
  ('Finance','FIN','FN300'),
  ('Operations','OPS','OP400');

INSERT INTO leave_types (name, description, max_days) VALUES
  ('Annual Leave','Yearly paid vacation',20),
  ('Sick Leave','Leave due to illness',10),
  ('Casual Leave','Short-notice personal matters',7),
  ('Emergency Leave','Urgent or unforeseen events',5);
