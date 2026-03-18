<?php
session_start();

require_once __DIR__ . '/../config/functions.php';

$login = $_POST['login'] ?? '';
$password = $_POST['password'] ?? '';

if ($login !== ADMIN_LOGIN) {
    header('Location: login.php?error=Identifiants incorrects');
    exit;
}

if (!password_verify($password, ADMIN_PASSWORD_HASH)) {
    header('Location: login.php?error=Identifiants incorrects');
    exit;
}

// connexion OK
$_SESSION['admin_logged_in'] = true;

// sécurité : régénérer l'id de session
session_regenerate_id(true);

header('Location: dashboard.php');
exit;