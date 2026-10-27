<?php
require __DIR__ . '/../includes/bootstrap.php';
$user = require_login('employee');

$stmt = db()->prepare(
    "SELECT la.status, COUNT(*) AS total
       FROM leave_applications la
       JOIN employees e ON e.id = la.employee_id
      WHERE e.user_id = :uid
      GROUP BY la.status"
);
$stmt->execute([':uid' => $user['id']]);
$counts = array_merge(['pending' => 0, 'approved' => 0, 'declined' => 0],
                      array_column($stmt->fetchAll(), 'total', 'status'));

$pageTitle = 'My Dashboard';
require __DIR__ . '/../includes/header.php';
?>
<h1 class="h3 mb-4">Hello, <?= e($user['name']) ?></h1>
<div class="row g-3">
  <?php foreach (['pending' => 'Pending', 'approved' => 'Approved', 'declined' => 'Declined'] as $key => $label): ?>
    <div class="col-12 col-md-4">
      <div class="card stat-card shadow-sm">
        <div class="card-body">
          <div class="text-muted small"><?= e($label) ?> requests</div>
          <div class="display-6"><?= (int)$counts[$key] ?></div>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>
<?php require __DIR__ . '/../includes/footer.php'; ?>
