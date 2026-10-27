<?php
function current_user(): ?array
{
    return $_SESSION['user'] ?? null;
}

function is_logged_in(): bool
{
    return current_user() !== null;
}

function home_for_role(string $role): string
{
    return $role === 'admin' ? 'admin/dashboard.php' : 'employee/dashboard.php';
}

function require_login(?string $role = null): array
{
    $user = current_user();
    if ($user === null) {
        flash('warning', 'Please sign in to continue.');
        redirect('login.php');
    }
    if ($role !== null && $user['role'] !== $role) {
        http_response_code(403);
        exit('403 - You do not have access to this page.');
    }
    return $user;
}

function login_is_locked(): bool
{
    $until = $_SESSION['login_lock_until'] ?? 0;
    if ($until > time()) {
        return true;
    }
    if ($until !== 0) {                       
        unset($_SESSION['login_lock_until'], $_SESSION['login_fails']);
    }
    return false;
}

function register_failed_login(): void
{
    $_SESSION['login_fails'] = ($_SESSION['login_fails'] ?? 0) + 1;
    if ($_SESSION['login_fails'] >= MAX_LOGIN_ATTEMPTS) {
        $_SESSION['login_lock_until'] = time() + LOGIN_LOCK_SECONDS;
    }
}

function attempt_login(string $email, string $password): array
{
    $stmt = db()->prepare('SELECT id, full_name, email, password_hash, role, status
                           FROM users WHERE email = :email LIMIT 1');
    $stmt->execute([':email' => $email]);
    $u = $stmt->fetch();

    if (!$u || !password_verify($password, $u['password_hash'])) {
        register_failed_login();
        return ['ok' => false, 'error' => 'Invalid email or password.'];
    }
    if ((int)$u['status'] !== 1) {
        return ['ok' => false, 'error' => 'Your account is inactive. Please contact the administrator.'];
    }

    session_regenerate_id(true);             
    unset($_SESSION['login_fails'], $_SESSION['login_lock_until']);
    $_SESSION['user'] = [
        'id'    => (int)$u['id'],
        'name'  => $u['full_name'],
        'email' => $u['email'],
        'role'  => $u['role'],
    ];
    return ['ok' => true];
}

function logout_user(): void
{
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $p = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $p['path'], $p['domain'], $p['secure'], $p['httponly']);
    }
    session_destroy();
}
