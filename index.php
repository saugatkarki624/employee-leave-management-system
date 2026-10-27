<?php
require __DIR__ . '/includes/bootstrap.php';
if (is_logged_in()) {
    redirect(home_for_role(current_user()['role']));
}
redirect('login.php');
