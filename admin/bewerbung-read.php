<?php
require_once __DIR__ . '/auth.php';
$page = 'bewerbungen';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id < 1) {
    flash('error', 'Ungueltige Bewerbungs-ID.');
    redirect('bewerbungen.php');
}

$item = dbRow("SELECT * FROM bewerbungen WHERE id = ?", [$id]);
if (!$item) {
    flash('error', 'Bewerbung nicht gefunden.');
    redirect('bewerbungen.php');
}

// Mark as read
if (empty($item['is_read'])) {
    dbExec("UPDATE bewerbungen SET is_read = 1 WHERE id = ?", [$id]);
    $item['is_read'] = 1;
}
?>
<!doctype html>
<html lang="de">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Bewerbung von <?= h(($item['vorname'] ?? '') . ' ' . ($item['nachname'] ?? '')) ?> — gut salzig Admin</title>
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
      <a href="bewerbungen.php" class="btn-back">&larr; Alle Bewerbungen</a>
      <h1>&female; <em>Bewerbung</em></h1>
    </div>
  </div>

  <div style="background:var(--surface);border:1px solid var(--line);padding:2rem;max-width:720px;">

    <div class="form-row">
      <div class="field">
        <label>Vorname</label>
        <div style="padding:0.6rem 0;font-size:1rem;"><?= h($item['vorname'] ?? '—') ?></div>
      </div>
      <div class="field">
        <label>Nachname</label>
        <div style="padding:0.6rem 0;font-size:1rem;"><?= h($item['nachname'] ?? '—') ?></div>
      </div>
    </div>

    <div class="form-row">
      <div class="field">
        <label>E-Mail</label>
        <div style="padding:0.6rem 0;font-size:1rem;">
          <?php if (!empty($item['email'])): ?>
            <a href="mailto:<?= h($item['email']) ?>" style="color:var(--accent);text-decoration:underline;"><?= h($item['email']) ?></a>
          <?php else: ?>
            &mdash;
          <?php endif; ?>
        </div>
      </div>
      <div class="field">
        <label>Telefon</label>
        <div style="padding:0.6rem 0;font-size:1rem;">
          <?php if (!empty($item['phone'])): ?>
            <a href="tel:<?= h($item['phone']) ?>" style="color:var(--accent);text-decoration:underline;"><?= h($item['phone']) ?></a>
          <?php else: ?>
            &mdash;
          <?php endif; ?>
        </div>
      </div>
    </div>

    <div class="form-row">
      <div class="field">
        <label>Stelle</label>
        <div style="padding:0.6rem 0;font-size:1rem;"><?= h($item['stelle'] ?? '—') ?></div>
      </div>
      <div class="field">
        <label>Wohnort</label>
        <div style="padding:0.6rem 0;font-size:1rem;"><?= h($item['wohnort'] ?? '—') ?></div>
      </div>
    </div>

    <div class="form-row">
      <div class="field">
        <label>Erfahrung</label>
        <div style="padding:0.6rem 0;font-size:1rem;"><?= h($item['erfahrung'] ?? '—') ?></div>
      </div>
      <div class="field">
        <label>Verfuegbar ab</label>
        <div style="padding:0.6rem 0;font-size:1rem;">
          <?= !empty($item['verfuegbar']) ? h($item['verfuegbar']) : '—' ?>
        </div>
      </div>
    </div>

    <div class="form-row s1">
      <div class="field">
        <label>Besondere Anforderungen</label>
        <div style="padding:0.6rem 0;font-size:1rem;"><?= h($item['needs'] ?? '—') ?></div>
      </div>
    </div>

    <div style="margin-top:1.5rem;border-top:1px solid var(--line);padding-top:1.5rem;">
      <label style="display:block;margin-bottom:0.5rem;font-weight:500;font-size:0.75rem;text-transform:uppercase;letter-spacing:0.06em;color:var(--ink-soft);">Motivation</label>
      <div style="padding:1rem;background:var(--bg);border:1px solid var(--line);border-radius:4px;white-space:pre-wrap;line-height:1.7;font-size:0.95rem;"><?= h($item['motivation'] ?? '') ?></div>
    </div>

    <div style="margin-top:1rem;border-top:1px solid var(--line);padding-top:1rem;">
      <label style="display:block;margin-bottom:0.3rem;font-weight:500;font-size:0.75rem;text-transform:uppercase;letter-spacing:0.06em;color:var(--ink-soft);">Eingegangen am</label>
      <div style="font-family:var(--ff-mono);font-size:0.85rem;">
        <?= date('d.m.Y H:i', strtotime($item['created_at'])) ?> Uhr
      </div>
    </div>

    <div style="margin-top:2rem;display:flex;gap:1rem;align-items:center;">
      <a href="bewerbungen.php" class="btn-submit" style="display:inline-block;text-decoration:none;">&larr; Zurueck</a>
      <span class="status <?= $item['is_read'] ? 'status--active' : 'status--inactive' ?>" style="font-size:0.75rem;">
        <?= $item['is_read'] ? 'Gelesen' : 'Ungelesen' ?>
      </span>
    </div>

  </div>

</main>
</div>
</body>
</html>
