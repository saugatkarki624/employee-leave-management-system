<?php
require __DIR__ . '/includes/bootstrap.php';

if (is_logged_in()) {
    redirect(home_for_role(current_user()['role']));
}

$error = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!csrf_verify()) {
        $error = 'Session expired. Please try again.';
    } elseif (login_is_locked()) {
        $error = 'Too many failed attempts. Please wait a few minutes and try again.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL) || $password === '') {
        $error = 'Please enter a valid email and password.';
    } else {
        $result = attempt_login($email, $password);
        if ($result['ok']) {
            redirect(home_for_role(current_user()['role']));
        }
        $error = $result['error'];
    }
}

$pageTitle = 'Sign in';
require __DIR__ . '/includes/header.php';
?>
<div class="card shadow-sm login-card">
  <div class="card-body p-4">
    <h1 class="h4 text-center mb-1"><i class="bi bi-calendar2-check text-primary"></i> <?= e(APP_NAME) ?></h1>
    <p class="text-center text-muted mb-4">Sign in to continue</p>

    <?php if ($error): ?>
      <div class="alert alert-danger"><?= e($error) ?></div>
    <?php endif; ?>

    <form method="post" novalidate>
      <?= csrf_field() ?>
      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email"
               value="<?= e($email) ?>" required autofocus>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password" required>
      </div>
      <button type="submit" class="btn btn-primary w-100">Sign in</button>
    </form>
  </div>
</div>
<?php require __DIR__ . '/includes/footer.php'; ?>
