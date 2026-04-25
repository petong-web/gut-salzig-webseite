<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/functions.php';
session_start();

$title = "Brunch & Frühstück — gut salzig · Stein an der Ostsee";
$description = "Samstags gemütliches Frühstück à la carte, sonntags großer Brunch mit wöchentlich wechselndem Menü direkt an der Kieler Förde.";

// Pull active brunch
$brunch = dbRow("SELECT * FROM brunch WHERE is_active = 1 ORDER BY week_date DESC LIMIT 1");
$menuItems = [];
if ($brunch && !empty($brunch['menu_items'])) {
    $menuItems = json_decode($brunch['menu_items'], true) ?: [];
}
$brunchDate = $brunch ? formatDate($brunch['week_date'], 'l, d. F Y') : 'Sonntag';
?>
<!doctype html>
<html lang="de">
<head>
<?php require 'includes/head.php'; ?>
</head>
<body>
<?php require 'includes/nav.php'; ?>



<!-- HERO -->
<section class="subpage-hero">
  <div class="subpage-hero__media">
    <img src="prototype/assets/images/tile-brunch.jpg" alt="Brunch-Buffet bei gut salzig">
  </div>
  <div class="subpage-hero__content">
    <nav class="subpage-hero__breadcrumb">
      <a href="index.php">Home</a>
      <span class="sep">/</span>
      <span class="current">Brunch &amp; Fr&uuml;hst&uuml;ck</span>
    </nav>
    <span class="subpage-hero__eyebrow">Samstag &amp; Sonntag</span>
    <h1 class="subpage-hero__title">Das sch&ouml;nste Fr&uuml;hst&uuml;ck<br>der <em>Woche</em>.</h1>
    <p class="subpage-hero__sub">Samstags gem&uuml;tliches Fr&uuml;hst&uuml;ck &agrave; la carte. Sonntags unser gro&szlig;er Brunch mit w&ouml;chentlich wechselndem Men&uuml;, frisch gebackenem Brot, Fisch, K&auml;se und vielen Kleinigkeiten zum Probieren.</p>
  </div>
  <div class="subpage-hero__bar">
    <span>54&deg;26&prime;N &middot; 10&deg;14&prime;E &middot; Stein</span>
    <span class="subpage-hero__bar-flight">GS &middot; BRUNCH &middot; 042</span>
    <span>Reservierung empfohlen</span>
  </div>
</section>

<!-- Zwei Angebote nebeneinander -->
<section class="subpage-section">
  <div class="wrap">
    <div class="page-head reveal">
      <span class="eyebrow">Zwei Angebote</span>
      <h2>Wochenende beginnt <em>am Tisch</em>.</h2>
      <p>Wir haben das Wochenende in zwei Geschwindigkeiten aufgeteilt &mdash; einen ruhigen Samstag-Morgen und einen ausgiebigen Sonntags-Brunch. Beides l&auml;sst sich zur Reservierung anmelden.</p>
    </div>

    <div class="brunch__days" style="max-width: 900px; margin: 0 auto 4rem; grid-template-columns: 1fr 1fr; gap: 1.4rem;">
      <div class="brunch__day">
        <div class="brunch__day-label">Samstag</div>
        <div class="brunch__day-title">Fr&uuml;hst&uuml;cks-<br>Buffet</div>
        <div class="brunch__day-meta">9:30 &ndash; 11:30 Uhr &middot; 20,50 &euro; p. P.<br>vielf&auml;ltige Auswahl am Buffet</div>
      </div>
      <div class="brunch__day brunch__day--highlight">
        <div class="brunch__day-label">Sonntag</div>
        <div class="brunch__day-title">Brunch-<br>Buffet</div>
        <div class="brunch__day-meta">10 &ndash; 14 Uhr &middot; 33,80 &euro; p. P.<br>w&ouml;chentlich neues Men&uuml;</div>
      </div>
    </div>
  </div>
</section>

<!-- Brunch-Wochenmenü (dynamisch) -->
<section class="brunch" id="brunch">
  <div class="wrap">
    <div class="brunch__grid">
      <div class="brunch__content reveal">
        <span class="eyebrow"><?= $brunch ? h($brunchDate) : 'Sonntag' ?></span>
        <h2>Diese Woche auf<br>dem <em>Tisch</em>.</h2>
        <?php if ($brunch && !empty($brunch['description'])): ?>
        <p><?= h($brunch['description']) ?></p>
        <?php else: ?>
        <p>Jeden Sonntag kuratieren wir ein neues Brunch-Men&uuml;. Frisch gebackenes Brot aus der eigenen K&uuml;che, Fisch vom heimischen Kutter, regionale K&auml;se, S&uuml;&szlig;es und Herzhaftes &mdash; alles zum ausgiebigen Probieren.</p>
        <?php endif; ?>

        <span class="brunch__menu-label">Unser Brunch-Men&uuml;</span>
        <ul class="brunch__menu">
<?php if (!empty($menuItems)): ?>
  <?php foreach ($menuItems as $i => $item): ?>
          <li data-n="<?= str_pad($i + 1, 2, '0', STR_PAD_LEFT) ?>"><?= h($item) ?></li>
  <?php endforeach; ?>
<?php else: ?>
          <li data-n="01">Das aktuelle Men&uuml; wird bald ver&ouml;ffentlicht.</li>
<?php endif; ?>
        </ul>

        <a href="reservieren.php" class="btn btn--primary">Platz reservieren <span class="arrow">&rarr;</span></a>
      </div>
      <div class="brunch__image reveal">
        <span class="brunch__badge">Live &middot; jeden Sonntag neu</span>
        <?php if ($brunch && !empty($brunch['image'])): ?>
        <img src="<?= h($brunch['image']) ?>" alt="Sonntagsbrunch bei gut salzig">
        <?php else: ?>
        <img src="prototype/assets/images/brunch-vertical.jpg" alt="Sonntagsbrunch bei gut salzig">
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>

<!-- Samstag Frühstück Karte -->
<section class="subpage-section subpage-section--cream">
  <div class="wrap">
    <div class="page-head reveal">
      <span class="eyebrow">Samstag</span>
      <h2>Fr&uuml;hst&uuml;ck <em>&agrave; la carte</em>.</h2>
      <p>Gem&uuml;tlicher Start ins Wochenende. Entspannte Atmosph&auml;re, langsames Tempo &mdash; f&uuml;r alle, die den Tisch lieber f&uuml;r sich haben statt sich am Buffet einzureihen.</p>
    </div>

    <div class="celebrations__grid reveal-stagger" style="max-width: 1100px; margin-inline: auto;">
      <article class="celebration">
        <img src="prototype/assets/images/dish-3.jpg" alt="Klassisches Fr&uuml;hst&uuml;ck">
        <div class="luggage-tag" aria-hidden="true">
          <span class="luggage-tag__number">No. 01</span>
          <span class="luggage-tag__label">Klassisch</span>
          <span class="luggage-tag__code">GS &middot; BFK</span>
        </div>
        <div class="celebration__body">
          <h3>Gut Salzig <em>Klassik</em></h3>
          <p>Brot &middot; K&auml;se &middot; Schinken &middot; Ei &mdash; 14 &euro;</p>
        </div>
      </article>
      <article class="celebration">
        <img src="prototype/assets/images/intro-food.jpg" alt="Fr&uuml;chte-Fr&uuml;hst&uuml;ck">
        <div class="luggage-tag" aria-hidden="true">
          <span class="luggage-tag__number">No. 02</span>
          <span class="luggage-tag__label">Vital</span>
          <span class="luggage-tag__code">GS &middot; VIT</span>
        </div>
        <div class="celebration__body">
          <h3>Vital-<em>Fr&uuml;hst&uuml;ck</em></h3>
          <p>Joghurt &middot; Granola &middot; Obst &middot; Honig &mdash; 12 &euro;</p>
        </div>
      </article>
      <article class="celebration">
        <img src="prototype/assets/images/dish-2.jpg" alt="Deluxe Fr&uuml;hst&uuml;ck">
        <div class="luggage-tag" aria-hidden="true">
          <span class="luggage-tag__number">No. 03</span>
          <span class="luggage-tag__label">Deluxe</span>
          <span class="luggage-tag__code">GS &middot; LUX</span>
        </div>
        <div class="celebration__body">
          <h3>Ostsee <em>Deluxe</em></h3>
          <p>Lachs &middot; Krabben &middot; Avocado &middot; R&uuml;hrei &mdash; 22 &euro;</p>
        </div>
      </article>
    </div>
  </div>
</section>

<!-- FAQ -->
<section class="subpage-section">
  <div class="wrap">
    <div class="page-head reveal">
      <span class="eyebrow">Gut zu wissen</span>
      <h2>H&auml;ufige <em>Fragen</em>.</h2>
    </div>

    <div class="captains-log__grid reveal-stagger" style="max-width: 1100px; margin-inline: auto;">
      <article class="log-entry">
        <span class="log-entry__ribbon">FAQ &middot; 01</span>
        <div class="log-entry__header">
          <h3 class="log-entry__title">Muss ich <em>reservieren</em>?</h3>
        </div>
        <p class="log-entry__body">Ja, wir empfehlen unbedingt eine Reservierung &mdash; besonders f&uuml;r den Sonntagsbrunch. Die Pl&auml;tze sind schnell vergeben, vor allem in der Saison.</p>
      </article>
      <article class="log-entry">
        <span class="log-entry__ribbon">FAQ &middot; 02</span>
        <div class="log-entry__header">
          <h3 class="log-entry__title">Wie lange darf ich <em>bleiben</em>?</h3>
        </div>
        <p class="log-entry__body">So lange du magst! Beim Brunch planen wir ca. 2 Stunden pro Tisch ein, aber wenn es nicht voll ist, freuen wir uns &uuml;ber jede Minute mehr.</p>
      </article>
      <article class="log-entry">
        <span class="log-entry__ribbon">FAQ &middot; 03</span>
        <div class="log-entry__header">
          <h3 class="log-entry__title">Sind <em>Kinder</em> willkommen?</h3>
        </div>
        <p class="log-entry__body">Absolut. Wir haben Hochst&uuml;hle, kindgerechte Portionen und im Sommer Sandkasten &amp; Spielzeug am Strand. Kinder bis 6 Jahre brunchen gratis.</p>
      </article>
    </div>
  </div>
</section>


<?php require 'includes/footer.php'; ?>
</body>
</html>
