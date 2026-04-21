<?php
session_start();
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/../functions.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    $user = dbRow("SELECT * FROM users WHERE username = ?", [$username]);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION[ADMIN_SESSION_NAME] = [
            'id'       => $user['id'],
            'username' => $user['username'],
        ];
        redirect('index.php');
    } else {
        $error = 'Benutzername oder Passwort falsch.';
    }
}
?>
<!doctype html>
<html lang="de">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Login — gut salzig Admin</title>
<link rel="icon" type="image/svg+xml" href="../prototype/assets/logo/icon-blk.svg">
<link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,300;1,9..144,300&family=IBM+Plex+Mono:wght@400;500;600&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="admin.css">
</head>
<body class="login-page">

<div class="login">
  <div class="login__brand">
    <img src="../prototype/assets/logo/logo2-blk.svg" alt="gut salzig" class="login__logo">
    <span class="login__subtitle">Flight Dispatcher · Admin Panel</span>
  </div>

  <?php if ($error): ?>
    <div class="flash flash--error"><?= h($error) ?></div>
  <?php endif; ?>

  <form method="post" class="login__form">
    <div class="field">
      <label for="username">Crew Member</label>
      <input type="text" id="username" name="username" placeholder="Benutzername" required autofocus>
    </div>
    <div class="field">
      <label for="password">Access Code</label>
      <input type="password" id="password" name="password" placeholder="Passwort" required>
    </div>
    <button type="submit" class="btn-submit">Check-in <span>→</span></button>
  </form>

  <p class="login__footer">© <?= date('Y') ?> gut salzig · Stein · Ostsee</p>
</div>

</body>
</html>
