<?php
session_start();
require __DIR__ . '/config/database.php';
$step = 1; $error = ''; $message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    if ($action === 'check_email') {
        $email = trim($_POST['email'] ?? '');
        $check = $pdo->prepare('SELECT id, name, email FROM users WHERE email = ? LIMIT 1');
        $check->execute([$email]);
        $account = $check->fetch();
        if ($account) {
            $_SESSION['reset_user_id'] = (int)$account['id'];
            $_SESSION['reset_user_email'] = $account['email'];
            $step = 2;
        } else { $error = 'This email address is not registered in SIMS.'; }
    }
    if ($action === 'reset_password') {
        $password = $_POST['password'] ?? ''; $confirm = $_POST['confirm_password'] ?? '';
        if (!isset($_SESSION['reset_user_id'])) { $error = 'Please enter your email first.'; }
        elseif (strlen($password) < 6) { $error = 'Your new password must have at least 6 characters.'; $step = 2; }
        elseif ($password !== $confirm) { $error = 'The two passwords do not match.'; $step = 2; }
        else {
            $update = $pdo->prepare('UPDATE users SET password_hash = ? WHERE id = ?');
            $update->execute([password_hash($password, PASSWORD_DEFAULT), $_SESSION['reset_user_id']]);
            unset($_SESSION['reset_user_id'], $_SESSION['reset_user_email']);
            $message = 'Password changed successfully. You can now sign in.'; $step = 3;
        }
    }
}
?>
<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>SIMS | Reset Password</title><link rel="stylesheet" href="assets/css/style.css"></head><body class="login-page"><main class="login-shell"><section class="brand-panel"><div class="logo"><span>✎</span><div><strong>SIMS</strong><small>Stationery Inventory<br>Management System</small></div></div><div class="hero-copy"><h1>Reset Your Password</h1><p>Use your registered SIMS email to choose a new password.</p></div></section><section class="form-panel"><div class="form-card"><p class="eyebrow">ACCOUNT RECOVERY</p><?php if($step===1):?><h2>Forgot password?</h2><p class="muted">Enter your registered email address.</p><?php elseif($step===2):?><h2>Create new password</h2><p class="muted">Account: <?=htmlspecialchars($_SESSION['reset_user_email'])?></p><?php else:?><h2>Password updated</h2><?php endif;?><?php if($error):?><div class="alert"><?=htmlspecialchars($error)?></div><?php endif;?><?php if($message):?><div style="background:#dcfce7;color:#15803d;padding:12px;border-radius:7px;margin-top:18px;font-size:13px"><?=htmlspecialchars($message)?></div><?php endif;?><?php if($step===1):?><form method="post"><input type="hidden" name="action" value="check_email"><label>Email address</label><input type="email" name="email" required placeholder="Enter your email"><button class="primary-btn" type="submit">Continue</button></form><?php elseif($step===2):?><form method="post"><input type="hidden" name="action" value="reset_password"><label>New password</label><input type="password" name="password" minlength="6" required placeholder="At least 6 characters"><label>Confirm new password</label><input type="password" name="confirm_password" minlength="6" required placeholder="Enter new password again"><button class="primary-btn" type="submit">Update Password</button></form><?php endif;?><p class="footer-text"><a href="index.php">← Back to login</a></p></div></section></main></body></html>
