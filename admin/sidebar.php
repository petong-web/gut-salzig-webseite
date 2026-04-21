<?php
// $page variable should be set before including this file
$page = $page ?? '';

// Unread counts for badges
try {
    $unreadMsg = dbRow("SELECT COUNT(*) as c FROM contact_messages WHERE is_read = 0")['c'] ?? 0;
    $unreadApp = dbRow("SELECT COUNT(*) as c FROM bewerbungen WHERE is_read = 0")['c'] ?? 0;
} catch (Exception $e) {
    $unreadMsg = $unreadApp = 0;
}
?>
<aside class="sidebar">
  <div class="sidebar__brand">
    <img src="../prototype/assets/logo/logo2-wht.svg" alt="gut salzig">
    <span>Flight Dispatcher</span>
  </div>

  <nav class="sidebar__nav">
    <a href="index.php"             class="<?= $page === 'dashboard' ? 'is-active' : '' ?>"><span class="icon">◉</span> Dashboard</a>
    <a href="brunch.php"            class="<?= $page === 'brunch' ? 'is-active' : '' ?>"><span class="icon">☀</span> Brunch</a>
    <a href="events.php"            class="<?= $page === 'events' ? 'is-active' : '' ?>"><span class="icon">✈</span> Events</a>
    <a href="tagesgerichte.php"     class="<?= $page === 'tagesgerichte' ? 'is-active' : '' ?>"><span class="icon">◆</span> Tagesgerichte</a>
    <a href="speisekarte.php"       class="<?= $page === 'speisekarte' ? 'is-active' : '' ?>"><span class="icon">✦</span> Speisekarte</a>
    <a href="blog.php"              class="<?= $page === 'blog' ? 'is-active' : '' ?>"><span class="icon">✎</span> Captain's Log</a>
    <a href="jobs.php"              class="<?= $page === 'jobs' ? 'is-active' : '' ?>"><span class="icon">★</span> Jobs</a>
    <a href="kontakt-messages.php"  class="<?= $page === 'kontakt' ? 'is-active' : '' ?>">
      <span class="icon">♥</span> Nachrichten
      <?php if ($unreadMsg > 0): ?><span class="badge"><?= $unreadMsg ?></span><?php endif; ?>
    </a>
    <a href="bewerbungen.php"       class="<?= $page === 'bewerbungen' ? 'is-active' : '' ?>">
      <span class="icon">♪</span> Bewerbungen
      <?php if ($unreadApp > 0): ?><span class="badge"><?= $unreadApp ?></span><?php endif; ?>
    </a>
  </nav>

  <div class="sidebar__footer">
    <a href="logout.php">Logout · <?= h($adminUser) ?></a>
  </div>
</aside>
