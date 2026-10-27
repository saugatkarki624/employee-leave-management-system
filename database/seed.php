<?php
if (PHP_SAPI !== 'cli') { http_response_code(403); exit('Run this from the command line.'); }

require __DIR__ . '/../config/config.php';
$pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4', DB_USER, DB_PASS,
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

$accounts = [
    ['Admin User',    'admin@elms.test', 'Admin@12345', 'admin'],
    ['Demo Employee', 'emp@elms.test',   'Employee@123', 'employee'],
];

$insUser = $pdo->prepare('INSERT INTO users (full_name,email,password_hash,role) VALUES (?,?,?,?)');
$insEmp  = $pdo->prepare('INSERT INTO employees (user_id,emp_code,department_id) VALUES (?,?,?)');
$exists  = $pdo->prepare('SELECT id FROM users WHERE email = ?');

foreach ($accounts as [$name, $email, $plain, $role]) {
    $exists->execute([$email]);
    if ($exists->fetch()) { echo "Skipped (already exists): $email\n"; continue; }
    $insUser->execute([$name, $email, password_hash($plain, PASSWORD_DEFAULT), $role]);
    $uid = (int)$pdo->lastInsertId();
    if ($role === 'employee') { $insEmp->execute([$uid, 'EMP001', 1]); }
    echo "Created $role: $email / $plain\n";
}
echo "Done. Change these passwords after first login.\n";
