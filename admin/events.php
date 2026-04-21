<?php
require_once __DIR__ . '/auth.php';
$page = 'events';

$events = dbQuery("SELECT * FROM events ORDER BY event_date DESC");
?>
<!doctype html>
<html lang="de">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Events — gut salzig Admin</title>
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
    <h1>✈ <em>Events</em></h1>
    <a href="event-edit.php" class="btn-new">+ Neues Event</a>
  </div>

  <?php if (empty($events)): ?>
    <div style="background:var(--surface);border:1px solid var(--line);padding:3rem;text-align:center;">
      <p style="font-family:var(--ff-display);font-style:italic;font-size:1.4rem;color:var(--ink-soft);margin-bottom:1rem;">Noch keine Events.</p>
      <p style="color:var(--ink-mute);font-size:0.85rem;">Erstelle dein erstes Event über den Button oben.</p>
    </div>
  <?php else: ?>
    <div class="table-wrap">
      <table>
        <thead>
          <tr>
            <th>Flight</th>
            <th>Event</th>
            <th>Datum</th>
            <th>Kategorie</th>
            <th>Ticket</th>
            <th>Status</th>
            <th>Aktionen</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach ($events as $e): ?>
          <tr>
            <td style="font-family:var(--ff-mono);font-size:0.75rem;font-weight:600;color:var(--accent);">
              GS&nbsp;<?= str_pad($e['id'], 2, '0', STR_PAD_LEFT) ?>
            </td>
            <td>
              <strong><?= h($e['title']) ?></strong>
              <br><span style="font-family:var(--ff-mono);font-size:0.65rem;color:var(--ink-mute);">STN → <?= h($e['iata_code']) ?></span>
            </td>
            <td style="font-family:var(--ff-mono);font-size:0.78rem;">
              <?= date('d.m.Y', strtotime($e['event_date'])) ?>
              <br><span style="color:var(--ink-mute);"><?= date('H:i', strtotime($e['event_time'])) ?></span>
            </td>
            <td><?= h($e['category_icon']) ?> <?= h($e['category']) ?></td>
            <td>
              <?php
                $tl = ['free'=>'Free','ticket'=>'Ticket','reserve'=>'Reserve'];
                $tc = ['free'=>'var(--ink-mute)','ticket'=>'var(--accent)','reserve'=>'var(--sage)'];
              ?>
              <span style="font-family:var(--ff-mono);font-size:0.65rem;font-weight:600;letter-spacing:0.12em;text-transform:uppercase;color:<?= $tc[$e['ticket_type']] ?>;">
                <?= $tl[$e['ticket_type']] ?><?= $e['price'] ? ' · '.number_format($e['price'],0).' €' : '' ?>
              </span>
            </td>
            <td><span class="status <?= $e['is_active'] ? 'status--active' : 'status--inactive' ?>"><?= $e['is_active'] ? 'Aktiv' : 'Inaktiv' ?></span></td>
            <td class="actions"><a href="event-edit.php?id=<?= $e['id'] ?>">Bearbeiten</a></td>
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
