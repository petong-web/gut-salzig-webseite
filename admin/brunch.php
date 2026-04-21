<?php
require_once __DIR__ . '/auth.php';
$page = 'brunch';

// Daten laden
try {
    switch ('brunch') {
        case 'brunch':
            $items = dbQuery("SELECT * FROM brunch ORDER BY week_date DESC LIMIT 10");
            break;
        case 'events':
            $items = dbQuery("SELECT * FROM events ORDER BY event_date DESC");
            break;
        case 'tagesgerichte':
            $items = dbQuery("SELECT * FROM tagesgerichte ORDER BY sort_order, id DESC");
            break;
        case 'speisekarte':
            $items = dbQuery("SELECT * FROM speisekarte ORDER BY category, sort_order");
            break;
        case 'blog':
            $items = dbQuery("SELECT * FROM blog ORDER BY created_at DESC");
            break;
        case 'jobs':
            $items = dbQuery("SELECT * FROM jobs ORDER BY sort_order, id DESC");
            break;
        case 'kontakt-messages':
            $items = dbQuery("SELECT * FROM contact_messages ORDER BY created_at DESC");
            break;
        case 'bewerbungen':
            $items = dbQuery("SELECT * FROM bewerbungen ORDER BY created_at DESC");
            break;
    }
} catch (Exception $e) {
    $items = [];
}
$count = count($items);
?>
<!doctype html>
<html lang="de">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Brunch — gut salzig Admin</title>
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
    <h1>☀ <em>Brunch</em></h1>
    <a href="brunch-edit.php" class="btn-new">+ Neu erstellen</a>
  </div>

  <?php if (empty($items)): ?>
    <div style="background:var(--surface);border:1px solid var(--line);padding:3rem;text-align:center;">
      <p style="font-family:var(--ff-display);font-style:italic;font-size:1.4rem;color:var(--ink-soft);margin-bottom:1rem;">Noch keine Einträge.</p>
      <p style="color:var(--ink-mute);font-size:0.85rem;">Erstelle den ersten Eintrag über den Button oben.</p>
    </div>
  <?php else: ?>
    <div class="table-wrap">
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Titel / Name</th>
            <th>Status</th>
            <th>Datum</th>
            <th>Aktionen</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach ($items as $item): ?>
          <tr>
            <td><?= $item['id'] ?></td>
            <td><?= h($item['title'] ?? $item['name'] ?? $item['eyebrow'] ?? $item['vorname'] ?? '—') ?></td>
            <td>
              <?php
                $active = $item['is_active'] ?? $item['is_published'] ?? $item['is_read'] ?? null;
                if ($active !== null):
              ?>
                <span class="status <?= $active ? 'status--active' : 'status--inactive' ?>">
                  <?= $active ? 'Aktiv' : 'Inaktiv' ?>
                </span>
              <?php else: ?>
                —
              <?php endif; ?>
            </td>
            <td style="font-family:var(--ff-mono);font-size:0.75rem;"><?= date('d.m.Y', strtotime($item['created_at'] ?? $item['event_date'] ?? $item['week_date'] ?? 'now')) ?></td>
            <td class="actions">
              <a href="brunch-edit.php?id=<?= $item['id'] ?>">Bearbeiten</a>
            </td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>

</main>
</div>
</body>
</html>
