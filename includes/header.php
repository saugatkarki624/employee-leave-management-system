<?php
$user = current_user();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e($pageTitle ?? 'Home') ?> | <?= e(APP_NAME) ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link href="<?= e(url('assets/css/style.css')) ?>" rel="stylesheet">
</head>
<body>
<?php if ($user): ?>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container">
    <a class="navbar-brand" href="<?= e(url(home_for_role($user['role']))) ?>">
      <i class="bi bi-calendar2-check"></i> ELMS
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="nav">
      <ul class="navbar-nav me-auto">
        <li class="nav-item"><a class="nav-link" href="<?= e(url(home_for_role($user['role']))) ?>">Dashboard</a></li>
        <?php ?>
      </ul>
      <span class="navbar-text me-3">
        <?= e($user['name']) ?> <span class="badge bg-light text-primary"><?= e(ucfirst($user['role'])) ?></span>
      </span>
      <a class="btn btn-outline-light btn-sm" href="<?= e(url('logout.php')) ?>">Logout</a>
    </div>
  </div>
</nav>
<?php endif; ?>
<main class="container py-4">
<?php foreach (get_flashes() as $f): ?>
  <div class="alert alert-<?= e($f['type']) ?> alert-dismissible fade show" role="alert">
    <?= e($f['message']) ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
<?php endforeach; ?>
s