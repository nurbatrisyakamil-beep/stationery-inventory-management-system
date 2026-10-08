<?php
require __DIR__ . '/config/database.php';
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $count = (int)$pdo->query('SELECT COUNT(*) FROM users')->fetchColumn();
    if ($count > 0) $message = 'Users already exist. Sign in from the login page.';
    else {
        $insert = $pdo->prepare('INSERT INTO users (name,email,password_hash,role) VALUES (?,?,?,?)');
        $insert->execute(['Administrator','admin@sims.test',password_hash('admin123', PASSWORD_DEFAULT),'admin']);
        $insert->execute(['Staff Member','staff@sims.test',password_hash('staff123', PASSWORD_DEFAULT),'staff']);
        $message = 'Setup complete. You can now sign in.';
    }
}
?>
<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>SIMS | Setup</title><link rel="stylesheet" href="assets/css/style.css"></head><body class="login-page"><main class="login-shell"><section class="brand-panel"><div class="logo"><span>✎</span><div><strong>SIMS</strong><small>Stationery Inventory<br>Management System</small></div></div><div class="hero-copy"><h1>First-time setup</h1><p>This creates the first Admin and Staff accounts safely in your MySQL database.</p></div></section><section class="form-panel"><div class="form-card"><p class="eyebrow">DATABASE SETUP</p><h2>Set up SIMS</h2><p class="muted">Do this once after importing the database.</p><?php if($message): ?><p class="alert"><?=htmlspecialchars($message)?></p><?php endif; ?><form method="post"><button class="primary-btn">Create Admin and Staff accounts</button></form><p class="hint"><strong>Admin:</strong> admin@sims.test / admin123<br><strong>Staff:</strong> staff@sims.test / staff123</p><p class="footer-text"><a href="index.php">Go to login</a></p></div></section></main></body></html>
