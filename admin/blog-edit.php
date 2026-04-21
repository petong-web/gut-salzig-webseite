<?php
require_once __DIR__ . '/auth.php';
$page = 'blog';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$isEdit = $id > 0;

// TODO: Load record if editing, handle POST save
?>
<!doctype html>
<html lang="de">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Log-Eintrag bearbeiten — gut salzig Admin</title>
<link rel="icon" type="image/svg+xml" href="../prototype/assets/logo/icon-blk.svg">
<link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,300;1,9..144,300&family=IBM+Plex+Mono:wght@400;500;600&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="admin.css">
</head>
<body>
<div class="admin-wrap">
<?php require __DIR__ . '/sidebar.php'; ?>
<main class="main">
  <?= renderFlash() ?>

  <div class="topbar">
    <div>
      <a href="blog.php" class="btn-back">← Zurück</a>
      <h1><?= $isEdit ? 'Bearbeiten' : 'Neu erstellen' ?></h1>
    </div>
  </div>

  <div style="background:var(--surface);border:1px solid var(--line);padding:2.5rem;">
    <p style="font-family:var(--ff-display);font-style:italic;font-size:1.4rem;color:var(--ink-soft);margin-bottom:1rem;">
      Formular wird in Phase 3–7 gebaut.
    </p>
    <p style="color:var(--ink-mute);font-size:0.85rem;">
      Dieses Formular wird als nächstes implementiert — mit allen Feldern, Foto-Upload und Validierung.
    </p>
  </div>

</main>
</div>
</body>
</html>
