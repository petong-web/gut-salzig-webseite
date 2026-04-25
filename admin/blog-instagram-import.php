<?php
require_once __DIR__ . '/auth.php';
$page = 'blog';

$results = [];
$importedCount = 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrfCheck();
    $urls = array_filter(array_map('trim', explode("\n", $_POST['urls'] ?? '')));

    foreach ($urls as $url) {
        // URL validieren
        if (!preg_match('#instagram\.com/(p|reel|tv)/([\w-]+)#', $url, $m)) {
            $results[] = ['url' => $url, 'status' => 'error', 'message' => 'Keine gültige Instagram-URL'];
            continue;
        }

        // Open Graph Metadaten versuchen zu holen (klappt nicht immer wegen IG-Blocks)
        $title = '';
        $caption = '';
        $imageUrl = '';

        $ctx = stream_context_create([
            'http' => [
                'timeout' => 8,
                'user_agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/121.0.0.0 Safari/537.36',
                'header' => "Accept: text/html,application/xhtml+xml\r\n"
            ]
        ]);

        $html = @file_get_contents($url, false, $ctx);
        if ($html) {
            if (preg_match('#<meta property="og:title" content="([^"]+)"#', $html, $titleMatch)) {
                $title = html_entity_decode($titleMatch[1], ENT_QUOTES, 'UTF-8');
            }
            if (preg_match('#<meta property="og:description" content="([^"]+)"#', $html, $descMatch)) {
                $caption = html_entity_decode($descMatch[1], ENT_QUOTES, 'UTF-8');
            }
            if (preg_match('#<meta property="og:image" content="([^"]+)"#', $html, $imgMatch)) {
                $imageUrl = $imgMatch[1];
            }
        }

        // Fallback-Titel
        if (empty($title)) {
            $title = 'Instagram-Post · ' . $m[2];
        }

        // Schon importiert?
        $existing = dbRow("SELECT id FROM blog WHERE instagram_url = ?", [$url]);
        if ($existing) {
            $results[] = ['url' => $url, 'status' => 'skipped', 'message' => 'Bereits importiert (ID ' . $existing['id'] . ')'];
            continue;
        }

        // Bild lokal speichern (falls Instagram OG-Image geliefert hat)
        $localImage = '';
        if ($imageUrl) {
            $imgData = @file_get_contents($imageUrl, false, $ctx);
            if ($imgData && strlen($imgData) > 5000) {
                $filename = 'ig-' . $m[2] . '-' . time() . '.jpg';
                $dir = UPLOAD_DIR . '/blog';
                if (!is_dir($dir)) mkdir($dir, 0755, true);
                if (file_put_contents($dir . '/' . $filename, $imgData)) {
                    $localImage = 'uploads/blog/' . $filename;
                }
            }
        }

        // In DB einfügen
        $slug = slugify($title) ?: 'ig-' . $m[2];
        $newId = dbInsert("INSERT INTO blog
            (entry_type, title, slug, body, instagram_url, instagram_caption, instagram_image,
             author, author_initial, location, is_published, published_at)
            VALUES ('instagram', ?, ?, '', ?, ?, ?, 'gut salzig', 'GS', 'Stein', 1, NOW())", [
            $title, $slug, $url, $caption, $localImage
        ]);

        $results[] = [
            'url' => $url,
            'status' => 'imported',
            'message' => "✓ Importiert (ID $newId)" . ($localImage ? ' mit Bild' : ' ohne Bild'),
            'title' => $title,
            'image' => $localImage,
            'id' => $newId
        ];
        $importedCount++;
    }

    if ($importedCount > 0) {
        flash('success', "$importedCount Posts importiert.");
    }
}

// Latest imports
$recent = dbQuery("SELECT * FROM blog WHERE entry_type = 'instagram' ORDER BY created_at DESC LIMIT 10");
?>
<!doctype html>
<html lang="de">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Instagram Bulk-Import — gut salzig Admin</title>
<link rel="icon" type="image/svg+xml" href="../prototype/assets/logo/icon-blk.svg">
<link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,300;1,9..144,300&family=IBM+Plex+Mono:wght@400;500;600&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="admin.css">
<style>
.result-row { padding:0.7rem 1rem; border-bottom:1px dashed var(--line); display:flex; align-items:center; gap:1rem; font-size:0.85rem; }
.result-row:last-child { border-bottom:0; }
.result-row.imported { background:#f0f5ee; color:#3a5e34; }
.result-row.skipped { background:var(--bg-2); color:var(--ink-mute); }
.result-row.error { background:#fef0f0; color:#8c3030; }
.result-thumb { width:60px; height:60px; object-fit:cover; flex-shrink:0; }
</style>
</head>
<body>
<div class="admin-wrap">
<?php require __DIR__ . '/sidebar.php'; ?>
<main class="main">
  <?= renderFlash() ?>

  <div class="topbar">
    <div>
      <a href="blog.php" class="btn-back">← Captain's Log</a>
      <h1>📷 Instagram <em>Bulk-Import</em></h1>
    </div>
    <a href="https://www.instagram.com/gut_salzig/" target="_blank" rel="noopener" class="btn-new">@gut_salzig öffnen ↗</a>
  </div>

  <div style="background:var(--bg-2);border:1px solid var(--line);padding:1.4rem;margin-bottom:1.5rem;font-size:0.85rem;line-height:1.7;color:var(--ink-soft);">
    <strong style="font-family:var(--ff-mono);font-size:0.62rem;letter-spacing:0.22em;text-transform:uppercase;color:var(--accent);display:block;margin-bottom:0.6rem;">⚠ Wichtig zu wissen</strong>
    Instagram blockiert automatische Datenabfragen sehr aggressiv. Das Tool versucht bei jedem Link die Vorschau-Daten (Titel, Bild) zu holen — bei manchen Posts klappt das, bei anderen nicht. <strong>Du kannst die importierten Einträge danach jederzeit im Editor nachbearbeiten</strong> (Titel, Caption, Cover-Bild).
  </div>

  <form method="post" style="background:var(--surface);border:1px solid var(--line);padding:2rem;margin-bottom:2rem;">
    <?= csrfField() ?>
    <div class="field">
      <label for="urls">Instagram Post-URLs (eine pro Zeile)</label>
      <textarea id="urls" name="urls" style="min-height:200px;font-family:var(--ff-mono);font-size:0.82rem;" placeholder="https://www.instagram.com/p/ABC123xyz/&#10;https://www.instagram.com/p/DEF456abc/&#10;https://www.instagram.com/reel/GHI789def/&#10;..." required></textarea>
      <p style="font-size:0.7rem;color:var(--ink-mute);line-height:1.6;margin-top:0.5rem;">
        <strong>So holst du URLs am schnellsten:</strong><br>
        1. Geh auf <a href="https://www.instagram.com/gut_salzig/" target="_blank" style="color:var(--accent);">instagram.com/gut_salzig</a><br>
        2. Klicke auf einen Post → URL aus der Adressleiste kopieren<br>
        3. Hier einfügen, nächsten Post öffnen, URL kopieren, einfügen, …
      </p>
    </div>
    <button type="submit" class="btn-submit" style="margin-top:1.5rem;">Posts importieren →</button>
  </form>

  <?php if (!empty($results)): ?>
    <div style="background:var(--surface);border:1px solid var(--line);margin-bottom:2rem;">
      <div style="padding:1rem 1.4rem;background:var(--bg);border-bottom:1px solid var(--line);font-family:var(--ff-mono);font-size:0.62rem;letter-spacing:0.22em;text-transform:uppercase;font-weight:600;color:var(--accent);">
        Import-Ergebnis · <?= $importedCount ?>/<?= count($results) ?> erfolgreich
      </div>
      <?php foreach ($results as $r): ?>
        <div class="result-row <?= $r['status'] ?>">
          <?php if (!empty($r['image'])): ?>
            <img src="../<?= h($r['image']) ?>" class="result-thumb" alt="">
          <?php else: ?>
            <div class="result-thumb" style="background:var(--bg);display:grid;place-items:center;color:var(--ink-mute);">📷</div>
          <?php endif; ?>
          <div style="flex:1;min-width:0;">
            <strong style="display:block;"><?= h($r['title'] ?? '—') ?></strong>
            <span style="font-family:var(--ff-mono);font-size:0.7rem;opacity:0.8;"><?= h($r['url']) ?></span>
          </div>
          <span style="font-size:0.78rem;font-weight:500;"><?= h($r['message']) ?></span>
          <?php if (!empty($r['id'])): ?>
            <a href="blog-edit.php?id=<?= $r['id'] ?>" style="font-family:var(--ff-mono);font-size:0.6rem;letter-spacing:0.2em;text-transform:uppercase;color:var(--accent);">Bearbeiten →</a>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

  <h2 style="font-family:var(--ff-display);font-size:1.4rem;font-weight:300;font-style:italic;margin:2rem 0 1rem;">Bereits importierte Instagram-Posts</h2>
  <?php if (empty($recent)): ?>
    <p style="color:var(--ink-mute);font-size:0.9rem;">Noch keine Instagram-Imports.</p>
  <?php else: ?>
    <div class="table-wrap">
      <table>
        <thead><tr><th>Bild</th><th>Titel</th><th>URL</th><th>Status</th><th>Aktion</th></tr></thead>
        <tbody>
        <?php foreach ($recent as $r): ?>
          <tr>
            <td>
              <?php if (!empty($r['instagram_image'])): ?>
                <img src="../<?= h($r['instagram_image']) ?>" style="width:50px;height:50px;object-fit:cover;">
              <?php else: ?>
                <div style="width:50px;height:50px;background:var(--bg);display:grid;place-items:center;font-size:1.2rem;">📷</div>
              <?php endif; ?>
            </td>
            <td><strong><?= h($r['title']) ?></strong></td>
            <td style="font-family:var(--ff-mono);font-size:0.7rem;"><a href="<?= h($r['instagram_url']) ?>" target="_blank">↗ Öffnen</a></td>
            <td><span class="status <?= $r['is_published'] ? 'status--active' : 'status--inactive' ?>"><?= $r['is_published'] ? 'Live' : 'Entwurf' ?></span></td>
            <td class="actions"><a href="blog-edit.php?id=<?= $r['id'] ?>">Bearbeiten</a></td>
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
