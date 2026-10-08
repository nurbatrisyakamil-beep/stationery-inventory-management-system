<?php
session_start();
require __DIR__ . '/config/database.php';
$error = ''; $success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = strtolower(trim($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? ''; $confirm = $_POST['confirm_password'] ?? '';
    if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) $error = 'Enter your full name and a valid UPTM email address.';
    elseif (!str_ends_with($email, '@uptm.edu.my')) $error = 'Please use your UPTM email address ending with @uptm.edu.my.';
    elseif (strlen($password) < 6) $error = 'Password must have at least 6 characters.';
    elseif ($password !== $confirm) $error = 'The passwords do not match.';
    else {
        try {
            $create = $pdo->prepare('INSERT INTO users (name,email,password_hash,role) VALUES (?,?,?,"staff")');
            $create->execute([$name, $email, password_hash($password, PASSWORD_DEFAULT)]);
            $success = 'Your Staff account has been created. You can now sign in.';
        } catch (PDOException $e) { $error = 'This UPTM email is already registered.'; }
    }
}
?>
<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>SIMS | Staff Registration</title><link rel="stylesheet" href="assets/css/style.css"></head><body class="login-page"><main class="login-shell"><section class="brand-panel"><div class="logo"><span>✎</span><div><strong>SIMS</strong><small>Stationery Inventory<br>Management System</small></div></div><div class="hero-copy"><h1>Create Your Staff Account</h1><p>Use your UPTM email to register and submit stationery requests.</p></div></section><section class="form-panel"><div class="form-card"><p class="eyebrow">STAFF SELF REGISTRATION</p><h2>Create Account</h2><p class="muted">Only UPTM email addresses are accepted.</p><?php if($error):?><div class="alert"><?=htmlspecialchars($error)?></div><?php endif;?><?php if($success):?><div style="background:#dcfce7;color:#15803d;padding:12px;border-radius:7px;margin-top:18px;font-size:13px"><?=htmlspecialchars($success)?></div><?php else:?><form method="post"><label>Full name</label><input name="name" required placeholder="Enter your full name" value="<?=htmlspecialchars($_POST['name']??'')?>"><label>UPTM email</label><input name="email" type="email" required placeholder="example@uptm.edu.my" value="<?=htmlspecialchars($_POST['email']??'')?>"><label>Password</label><input name="password" type="password" minlength="6" required placeholder="At least 6 characters"><label>Confirm password</label><input name="confirm_password" type="password" minlength="6" required placeholder="Enter password again"><button class="primary-btn" type="submit">Create Staff Account</button></form><?php endif;?><p class="footer-text"><a href="index.php">← Back to login</a></p></div></section></main></body></html>
