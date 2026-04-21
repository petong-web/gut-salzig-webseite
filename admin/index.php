<?php
require_once __DIR__ . '/auth.php';

$page = 'dashboard';

// Counts for dashboard stats
try {
    $eventCount    = dbRow("SELECT COUNT(*) as c FROM events WHERE is_active = 1 AND event_date >= CURDATE()")['c'] ?? 0;
    $jobCount      = dbRow("SELECT COUNT(*) as c FROM jobs WHERE is_active = 1")['c'] ?? 0;
    $msgCount      = dbRow("SELECT COUNT(*) as c FROM contact_messages WHERE is_read = 0")['c'] ?? 0;
    $appCount      = dbRow("SELECT COUNT(*) as c FROM bewerbungen WHERE is_read = 0")['c'] ?? 0;
    $blogCount     = dbRow("SELECT COUNT(*) as c FROM blog WHERE is_published = 1")['c'] ?? 0;
    $newsletterCount = dbRow("SELECT COUNT(*) as c FROM newsletter WHERE is_active = 1")['c'] ?? 0;
} catch (Exception $e) {
    // DB might not be installed yet
    $eventCount = $jobCount = $msgCount = $appCount = $blogCount = $newsletterCount = '—';
}
?>
<!doctype html>
<html lang="de">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Dashboard — gut salzig Admin</title>
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
    <h1>Flight <em>Dispatcher</em></h1>
    <span style="font-family:var(--ff-mono);font-size:0.6rem;letter-spacing:0.2em;text-transform:uppercase;color:var(--ink-mute);">
      <?= date('d. M Y · H:i') ?> CET
    </span>
  </div>

  <div class="stats">
    <a href="events.php" class="stat">
      <span class="stat__label">Aktive Events</span>
      <span class="stat__value"><?= $eventCount ?></span>
    </a>
    <a href="jobs.php" class="stat">
      <span class="stat__label">Offene Jobs</span>
      <span class="stat__value"><?= $jobCount ?></span>
    </a>
    <a href="kontakt-messages.php" class="stat">
      <span class="stat__label">Neue Nachrichten</span>
      <span class="stat__value stat__value--accent"><?= $msgCount ?></span>
    </a>
    <a href="bewerbungen.php" class="stat">
      <span class="stat__label">Neue Bewerbungen</span>
      <span class="stat__value stat__value--accent"><?= $appCount ?></span>
    </a>
    <a href="blog.php" class="stat">
      <span class="stat__label">Log-Einträge</span>
      <span class="stat__value"><?= $blogCount ?></span>
    </a>
    <a href="#" class="stat">
      <span class="stat__label">Newsletter Abos</span>
      <span class="stat__value"><?= $newsletterCount ?></span>
    </a>
  </div>

  <div style="background:var(--surface);border:1px solid var(--line);padding:2rem;margin-top:1rem;">
    <h2 style="font-family:var(--ff-display);font-size:1.4rem;font-weight:300;font-style:italic;margin-bottom:1rem;">Willkommen, <em style="color:var(--accent);"><?= h($adminUser) ?></em>.</h2>
    <p style="color:var(--ink-soft);line-height:1.7;font-size:0.9rem;">
      Von hier aus steuerst du alles: Brunch-Menüs, Events, Tagesgerichte, Captain's Log und mehr.
      Wähle links einen Bereich oder nutze die Karten oben für einen schnellen Überblick.
    </p>
    <p style="margin-top:1rem;font-family:var(--ff-mono);font-size:0.6rem;letter-spacing:0.2em;text-transform:uppercase;color:var(--ink-mute);">
      ✈ GS · ADMIN · <?= date('Y') ?> · STEIN · OSTSEE
    </p>
  </div>
</main>

</div>
</body>
</html>
