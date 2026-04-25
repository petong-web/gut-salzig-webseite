<?php
require_once __DIR__ . '/auth.php';
$page = 'reviews';
$items = dbQuery("SELECT * FROM reviews ORDER BY sort_order, review_date DESC, id DESC");
?>
<!doctype html>
<html lang="de">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Bewertungen — gut salzig Admin</title>
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
    <h1>★ <em>Bewertungen</em></h1>
    <a href="review-edit.php" class="btn-new">+ Neue Bewertung</a>
  </div>

  <div style="background:var(--bg-2);border:1px solid var(--line);padding:1.4rem;margin-bottom:1.5rem;font-size:0.85rem;line-height:1.7;color:var(--ink-soft);">
    <strong style="font-family:var(--ff-mono);font-size:0.62rem;letter-spacing:0.22em;text-transform:uppercase;color:var(--accent);display:block;margin-bottom:0.6rem;">💡 Tipp · Google Bewertungen übernehmen</strong>
    Geh auf <a href="https://www.google.com/maps/place/gut+salzig" target="_blank" style="color:var(--accent);">Google Maps → gut salzig</a>, kopiere Bewertungstext + Name + Datum, und füge sie hier per <strong>"+ Neue Bewertung"</strong> ein. So zeigst du echte Kundenstimmen auf der Website.
  </div>

  <?php if (empty($items)): ?>
    <div style="background:var(--surface);border:1px solid var(--line);padding:3rem;text-align:center;">
      <p style="font-family:var(--ff-display);font-style:italic;font-size:1.4rem;color:var(--ink-soft);margin-bottom:1rem;">Noch keine Bewertungen.</p>
      <a href="review-edit.php" class="btn-new" style="margin-top:1rem;display:inline-flex;">+ Erste Bewertung erstellen</a>
    </div>
  <?php else: ?>
    <div class="table-wrap">
      <table>
        <thead><tr><th>Autor</th><th>Bewertung</th><th>Text</th><th>Datum</th><th>Quelle</th><th>Status</th><th>Aktion</th></tr></thead>
        <tbody>
        <?php foreach ($items as $r): ?>
          <tr>
            <td><strong><?= h($r['author_name']) ?></strong></td>
            <td style="color:var(--gold);font-size:0.9rem;letter-spacing:0.1em;"><?= str_repeat('★', $r['rating']) . str_repeat('☆', 5 - $r['rating']) ?></td>
            <td style="max-width:400px;font-style:italic;color:var(--ink-soft);font-size:0.85rem;">
              <?= h(mb_substr($r['text'], 0, 120)) ?><?= mb_strlen($r['text']) > 120 ? '…' : '' ?>
            </td>
            <td style="font-family:var(--ff-mono);font-size:0.72rem;"><?= !empty($r['review_date']) ? date('d.m.Y', strtotime($r['review_date'])) : '—' ?></td>
            <td style="font-family:var(--ff-mono);font-size:0.62rem;letter-spacing:0.15em;text-transform:uppercase;color:var(--ink-mute);"><?= h($r['source']) ?></td>
            <td><span class="status <?= $r['is_active'] ? 'status--active' : 'status--inactive' ?>"><?= $r['is_active'] ? 'Aktiv' : 'Inaktiv' ?></span></td>
            <td class="actions"><a href="review-edit.php?id=<?= $r['id'] ?>">Bearbeiten</a></td>
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
