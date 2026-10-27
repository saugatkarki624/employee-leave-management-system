<?php
require __DIR__ . '/../includes/bootstrap.php';
$user = require_login('admin');

$pdo = db();
$stats = [
    'Employees'        => (int)$pdo->query("SELECT COUNT(*) FROM employees")->fetchColumn(),
    'Departments'      => (int)$pdo->query("SELECT COUNT(*) FROM departments")->fetchColumn(),
    'Leave Types'      => (int)$pdo->query("SELECT COUNT(*) FROM leave_types")->fetchColumn(),
    'Pending Requests' => (int)$pdo->query("SELECT COUNT(*) FROM leave_applications WHERE status='pending'")->fetchColumn(),
];

$pageTitle = 'Admin Dashboard';
require __DIR__ . '/../includes/header.php';
?>
<h1 class="h3 mb-4">Welcome, <?= e($user['name']) ?></h1>
<div class="row g-3">
  <?php foreach ($stats as $label => $count): ?>
    <div class="col-6 col-lg-3">
      <div class="card stat-card shadow-sm">
        <div class="card-body">
          <div class="text-muted small"><?= e($label) ?></div>
          <div class="display-6"><?= $count ?></div>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>
<?php require __DIR__ . '/../includes/footer.php'; ?>
