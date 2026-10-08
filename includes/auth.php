<?php
function require_login(): void {
    if (session_status() !== PHP_SESSION_ACTIVE) session_start();
    if (!isset($_SESSION['user_id'])) { header('Location: index.php'); exit; }
}
function require_admin(): void {
    require_login();
    if (($_SESSION['user_role'] ?? '') !== 'admin') { header('Location: dashboard.php'); exit; }
}
function require_staff(): void {
    require_login();
    if (($_SESSION['user_role'] ?? '') !== 'staff') { header('Location: dashboard.php'); exit; }
}
