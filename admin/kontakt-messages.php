<?php
require_once __DIR__ . '/auth.php';
$page = 'kontakt-messages';

// Daten laden
try {
    switch ('kontakt-messages') {
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
<title>Nachrichten — gut salzig Admin</title>
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
    <h1>&hearts; <em>Nachrichten</em></h1>
    <span style="font-family:var(--ff-mono);font-size:0.8rem;color:var(--ink-mute);"><?= $count ?> Eintr&auml;ge</span>
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
            <th>Name</th>
            <th>E-Mail</th>
            <th>Anlass</th>
            <th>Status</th>
            <th>Datum</th>
            <th>Aktionen</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach ($items as $item):
          $unread = empty($item['is_read']);
          $boldStyle = $unread ? 'font-weight:600;' : '';
        ?>
          <tr style="<?= $boldStyle ?>">
            <td><?= $item['id'] ?></td>
            <td><?= h($item['name'] ?? '—') ?></td>
            <td style="font-size:0.8rem;"><?= h($item['email'] ?? '—') ?></td>
            <td style="font-size:0.8rem;"><?= h($item['occasion'] ?? '—') ?></td>
            <td>
              <span class="status <?= $unread ? 'status--inactive' : 'status--active' ?>">
                <?= $unread ? 'Neu' : 'Gelesen' ?>
              </span>
            </td>
            <td style="font-family:var(--ff-mono);font-size:0.75rem;"><?= date('d.m.Y', strtotime($item['created_at'] ?? 'now')) ?></td>
            <td class="actions">
              <a href="kontakt-read.php?id=<?= $item['id'] ?>">Ansehen</a>
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
