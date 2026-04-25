<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/functions.php';
session_start();

$title = "Captain's Log — gut salzig · Geschichten aus dem Restaurant";
$description = "Logbuch-Einträge aus dem gut salzig: Geschichten aus der Küche, neue Menüs, Events und Momente vom Meer.";

$entries = dbQuery("SELECT * FROM blog WHERE is_published = 1 ORDER BY COALESCE(published_at, created_at) DESC, id DESC");
?>
<!doctype html>
<html lang="de">
<head>
<?php require 'includes/head.php'; ?>
</head>
<body>
<?php require 'includes/nav.php'; ?>

<section class="subpage-hero" style="min-height: 50vh;">
  <div class="subpage-hero__media"><img src="prototype/assets/images/hero-1.jpg" alt="Captain's Log"></div>
  <div class="subpage-hero__content">
    <nav class="subpage-hero__breadcrumb"><a href="index.php">Home</a><span class="sep">/</span><span class="current">News</span></nav>
    <span class="subpage-hero__eyebrow">Logbuch &middot; News &middot; Geschichten</span>
    <h1 class="subpage-hero__title">Captain's<br><em>Log</em>.</h1>
    <p class="subpage-hero__sub">Was heute in der K&uuml;che passiert, was morgen auf den Tisch kommt und was das Meer an Geschichten ansp&uuml;lt.</p>
  </div>
  <div class="subpage-hero__bar">
    <span><?= count($entries) ?> Eintr&auml;ge</span>
    <span class="subpage-hero__bar-flight">GS &middot; LOG &middot; ARCHIV</span>
    <span>Aktualisiert laufend</span>
  </div>
</section>

<section class="captains-log">
  <div class="wrap">
    <?php if (empty($entries)): ?>
      <div style="text-align:center;padding:4rem 1rem;color:var(--ink-mute);">
        <p style="font-family:var(--ff-display);font-style:italic;font-size:1.4rem;">Noch keine Eintr&auml;ge im Logbuch.</p>
      </div>
    <?php else: ?>
      <div class="captains-log__grid reveal-stagger">
        <?php foreach ($entries as $i => $entry):
          $entryNum = str_pad(($entry['entry_number'] ?? (count($entries) - $i)), 3, '0', STR_PAD_LEFT);
          $pubDate = !empty($entry['published_at']) ? formatDate($entry['published_at'], 'd.m.Y') : '';
          $isInsta = ($entry['entry_type'] ?? 'manual') === 'instagram';
          $coverImg = $isInsta ? ($entry['instagram_image'] ?? '') : ($entry['photo'] ?? '');
          $bodyText = $isInsta ? ($entry['instagram_caption'] ?? '') : ($entry['body'] ?? '');
          $authorInitial = $isInsta ? 'GS' : ($entry['author_initial'] ?? 'C.');
          $authorName = $isInsta ? '@gut_salzig' : ($entry['author'] ?? 'Crew');
        ?>
          <article class="log-entry <?= $isInsta ? 'log-entry--instagram' : '' ?>">
            <span class="log-entry__ribbon">
              <?= $isInsta ? '📷 Instagram' : 'Entry' ?> &middot; <?= h($entryNum) ?>
            </span>
            <?php if (!empty($coverImg)): ?>
              <div style="margin:0 -1.8rem 1rem; aspect-ratio:4/3; overflow:hidden;">
                <img src="<?= h($coverImg) ?>" alt="<?= h($entry['title']) ?>" style="width:100%;height:100%;object-fit:cover;">
              </div>
            <?php endif; ?>
            <div class="log-entry__header">
              <span class="log-entry__date">
                <?= h($pubDate) ?>
                <?php if (!empty($entry['location'])): ?> &middot; <?= h($entry['location']) ?><?php endif; ?>
              </span>
              <h3 class="log-entry__title"><?= h($entry['title']) ?></h3>
            </div>
            <?php if (!empty($bodyText)): ?>
              <p class="log-entry__body"><?= nl2br(h($bodyText)) ?></p>
            <?php endif; ?>
            <div class="log-entry__footer">
              <?php if ($isInsta && !empty($entry['instagram_url'])): ?>
                <a href="<?= h($entry['instagram_url']) ?>" target="_blank" rel="noopener"
                   style="font-family:var(--ff-mono);font-size:0.55rem;letter-spacing:0.2em;text-transform:uppercase;color:var(--ink-mute);">
                  Original-Post &uarr;
                </a>
              <?php else: ?>
                <span class="log-entry__signature"><?= h($authorInitial) ?></span>
              <?php endif; ?>
              <div class="log-entry__author"><strong><?= h($authorName) ?></strong>gut salzig</div>
            </div>
          </article>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>

<?php require 'includes/footer.php'; ?>
</body>
</html>
