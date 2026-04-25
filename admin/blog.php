<?php
require_once __DIR__ . '/auth.php';
$page = 'blog';

$items = dbQuery("SELECT * FROM blog ORDER BY published_at DESC, created_at DESC");
?>
<!doctype html>
<html lang="de">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Captain's Log — gut salzig Admin</title>
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
    <h1>✎ <em>Captain's Log</em></h1>
    <a href="blog-edit.php" class="btn-new">+ Neuer Eintrag</a>
  </div>

  <?php if (empty($items)): ?>
    <div style="background:var(--surface);border:1px solid var(--line);padding:3rem;text-align:center;">
      <p style="font-family:var(--ff-display);font-style:italic;font-size:1.4rem;color:var(--ink-soft);margin-bottom:1rem;">Noch keine Einträge.</p>
      <p style="color:var(--ink-mute);font-size:0.85rem;">Erstelle den ersten Eintrag — entweder als eigenen Text oder verlinke einen Instagram-Post.</p>
      <a href="blog-edit.php" class="btn-new" style="margin-top:1.5rem;display:inline-flex;">+ Ersten Eintrag erstellen</a>
    </div>
  <?php else: ?>
    <div class="table-wrap">
      <table>
        <thead>
          <tr>
            <th>Nr.</th>
            <th>Typ</th>
            <th>Titel</th>
            <th>Autor</th>
            <th>Veröffentlicht</th>
            <th>Status</th>
            <th>Aktionen</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach ($items as $item):
          $isInsta = ($item['entry_type'] ?? 'manual') === 'instagram';
        ?>
          <tr>
            <td style="font-family:var(--ff-mono);font-size:0.78rem;font-weight:600;color:var(--accent);">
              <?= str_pad($item['entry_number'] ?? $item['id'], 3, '0', STR_PAD_LEFT) ?>
            </td>
            <td>
              <?php if ($isInsta): ?>
                <span style="font-family:var(--ff-mono);font-size:0.55rem;letter-spacing:0.18em;text-transform:uppercase;font-weight:600;background:linear-gradient(45deg,#feda75,#fa7e1e,#d62976,#962fbf,#4f5bd5);background-clip:text;-webkit-background-clip:text;color:transparent;">📷 Instagram</span>
              <?php else: ?>
                <span style="font-family:var(--ff-mono);font-size:0.55rem;letter-spacing:0.18em;text-transform:uppercase;font-weight:600;color:var(--ink-mute);">✎ Manuell</span>
              <?php endif; ?>
            </td>
            <td>
              <strong><?= h($item['title']) ?></strong>
              <?php if ($isInsta && !empty($item['instagram_url'])): ?>
                <br><a href="<?= h($item['instagram_url']) ?>" target="_blank" rel="noopener" style="font-family:var(--ff-mono);font-size:0.6rem;color:var(--ink-mute);">Post öffnen ↗</a>
              <?php endif; ?>
            </td>
            <td><?= h($item['author'] ?? 'Captain') ?></td>
            <td style="font-family:var(--ff-mono);font-size:0.75rem;">
              <?= !empty($item['published_at']) ? date('d.m.Y', strtotime($item['published_at'])) : '—' ?>
            </td>
            <td>
              <span class="status <?= $item['is_published'] ? 'status--active' : 'status--inactive' ?>">
                <?= $item['is_published'] ? 'Live' : 'Entwurf' ?>
              </span>
            </td>
            <td class="actions"><a href="blog-edit.php?id=<?= $item['id'] ?>">Bearbeiten</a></td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>

  <div style="background:var(--bg-2);border:1px solid var(--line);padding:1.5rem;margin-top:2rem;font-size:0.82rem;color:var(--ink-soft);line-height:1.7;">
    <strong style="font-family:var(--ff-mono);font-size:0.62rem;letter-spacing:0.22em;text-transform:uppercase;color:var(--accent);display:block;margin-bottom:0.6rem;">💡 Tipp · Instagram als Quelle</strong>
    Du pflegst aktuell deinen Instagram-Kanal sehr aktiv? Klicke auf <strong>"+ Neuer Eintrag"</strong> und wähle den Tab <strong>"📷 Instagram-Post"</strong>. Füg einfach den Link deines Posts ein — er wird automatisch im Captain's Log auf der Website eingebettet (Foto, Caption, Likes). So musst du Inhalte nicht doppelt pflegen.
  </div>

</main>
</div>
</body>
</html>
