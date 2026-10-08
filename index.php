<?php
session_start();
require __DIR__ . '/config/database.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? ''); $password = $_POST['password'] ?? '';
    $statement = $pdo->prepare('SELECT id,name,email,password_hash,role FROM users WHERE email = ? LIMIT 1');
    $statement->execute([$email]); $user = $statement->fetch();
    if ($user && password_verify($password, $user['password_hash'])) {
        $_SESSION['user_id'] = (int)$user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_role'] = $user['role'];
        header('Location: dashboard.php');
        exit;
    }
    $error = 'Invalid email or password.';
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SIMS | Sign in</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="login-page">
  <main class="login-shell">
    <section class="brand-panel">
      <div class="logo"><span>✎</span><div><strong>SIMS</strong><small>Stationery Inventory<br>Management System</small></div></div>
      <div class="hero-copy"><h1>Manage Your Stationery Inventory with Ease</h1><p>Track, manage, and organize all your stationery items efficiently in one smart system.</p></div>
      <div class="desk-art" aria-hidden="true"><span>✏️</span><span>📚</span><span>🖇️</span></div>
    </section>
    <section class="form-panel">
      <div class="form-card">
        <p class="eyebrow">STATIONERY INVENTORY SYSTEM</p>
        <h2>Welcome Back! <span>👋</span></h2>
        <p class="muted">Please sign in to your account to continue.</p>
        <?php if ($error): ?><div class="alert"><?= htmlspecialchars($error) ?></div><?php endif; ?>
        <form method="post" novalidate>
          <label for="email">Email address</label>
          <input id="email" name="email" type="email" placeholder="Enter your email" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
          <label for="password">Password</label>
          <div class="password-wrap"><input id="password" name="password" type="password" placeholder="Enter your password" required><button type="button" class="show-password" aria-label="Show password">◉</button></div>
          <div class="form-row"><label class="check"><input type="checkbox" name="remember"> Remember me</label><a href="forgot_password.php">Forgot password?</a></div>
          <button class="primary-btn" type="submit">Sign in →</button>
        </form>
      
        <p class="footer-text">New Staff user? <a href="register.php">Create account with UPTM email</a></p>
      </div>
    </section>
  </main>
  <script src="assets/js/app.js"></script>
</body>
</html>
