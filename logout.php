<?php
require __DIR__ . '/includes/bootstrap.php';
logout_user();
session_start();                       // fresh session just to carry the flash message
flash('success', 'You have been signed out.');
redirect('login.php');
