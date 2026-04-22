<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/functions.php';
session_start();

$title = "Küche & Speisekarte — gut salzig · Kreative deutsche Küche mit Fisch";
$description = "Deutsche Kreativ-Küche mit Fokus auf Fisch aus heimischen Gewässern. À la carte, Tagesgerichte und saisonale Spezialitäten direkt an der Ostsee.";

// Pull active Tagesgerichte
$tagesgerichte = dbQuery("SELECT * FROM tagesgerichte WHERE is_active = 1 ORDER BY sort_order LIMIT 3");

// Pull active Speisekarte grouped by category
$speisekarte = dbQuery("SELECT * FROM speisekarte WHERE is_active = 1 ORDER BY category_sort, sort_order");

// Group speisekarte by category
$menuByCategory = [];
foreach ($speisekarte as $item) {
    $cat = $item['category'] ?? 'Sonstiges';
    $menuByCategory[$cat][] = $item;
}
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
    <img src="prototype/assets/images/tile-alacarte.jpg" alt="&Agrave; la carte bei gut salzig">
  </div>
  <div class="subpage-hero__content">
    <nav class="subpage-hero__breadcrumb">
      <a href="index.php">Home</a>
      <span class="sep">/</span>
      <span class="current">K&uuml;che &amp; Speisekarte</span>
    </nav>
    <span class="subpage-hero__eyebrow">Donnerstag &ndash; Sonntag</span>
    <h1 class="subpage-hero__title">Aus unserer<br><em>K&uuml;che</em>.</h1>
    <p class="subpage-hero__sub">Deutsche Kreativ-K&uuml;che mit einem klaren Herz f&uuml;r Fisch aus heimischen Gew&auml;ssern. W&ouml;chentlich wechselnde Tagesgerichte, sorgf&auml;ltig kuratierte &Agrave;-la-carte-Karte und saisonale Spezilit&auml;ten &mdash; frisch, ehrlich, mit einer Prise Salz.</p>
  </div>
  <div class="subpage-hero__bar">
    <span>54&deg;26&prime;N &middot; 10&deg;14&prime;E &middot; Stein</span>
    <span class="subpage-hero__bar-flight">GS &middot; KITCHEN &middot; 2026</span>
    <span>K&uuml;chenzeiten: 17 &ndash; 20 Uhr</span>
  </div>
</section>

<!-- Tagesgerichte (dynamisch) -->
<section class="subpage-section">
  <div class="wrap">
    <div class="page-head reveal">
      <span class="eyebrow">Diese Woche</span>
      <h2>Tages-<em>gerichte</em>.</h2>
      <p>Unsere Tagesgerichte wechseln w&ouml;chentlich &mdash; abh&auml;ngig davon, was der Kutter am Morgen anlandet und was die Saison hergibt. Jedes Gericht ist ein kleiner Moment gut salzig.</p>
    </div>

    <div class="celebrations__grid reveal-stagger" style="max-width: 1200px; margin-inline: auto;">
<?php if (!empty($tagesgerichte)): ?>
  <?php foreach ($tagesgerichte as $i => $dish): ?>
      <article class="celebration">
        <?php if (!empty($dish['image'])): ?>
        <img src="<?= h($dish['image']) ?>" alt="<?= h($dish['title']) ?>">
        <?php else: ?>
        <img src="prototype/assets/images/dish-<?= ($i % 3) + 1 ?>.jpg" alt="<?= h($dish['title']) ?>">
        <?php endif; ?>
        <div class="luggage-tag" aria-hidden="true">
          <span class="luggage-tag__number">No. <?= str_pad($i + 1, 2, '0', STR_PAD_LEFT) ?></span>
          <span class="luggage-tag__label"><?= h($dish['label'] ?? '') ?></span>
          <span class="luggage-tag__code"><?= h($dish['code'] ?? 'GS') ?></span>
        </div>
        <div class="celebration__body">
          <h3><?= $dish['title_html'] ?? h($dish['title']) ?></h3>
          <p><?= h($dish['description'] ?? '') ?><?php if (!empty($dish['price'])): ?> &mdash; <?= h($dish['price']) ?> &euro;<?php endif; ?></p>
        </div>
      </article>
  <?php endforeach; ?>
<?php else: ?>
      <article class="celebration">
        <img src="prototype/assets/images/dish-2.jpg" alt="Ostsee-Dorsch">
        <div class="luggage-tag" aria-hidden="true">
          <span class="luggage-tag__number">No. 01</span>
          <span class="luggage-tag__label">Tagesfisch</span>
          <span class="luggage-tag__code">GS &middot; DRS</span>
        </div>
        <div class="celebration__body">
          <h3>Ostsee-<em>Dorsch</em></h3>
          <p>Salzkartoffel-Stampf &middot; Spinat &middot; Senfbeurre &mdash; 24 &euro;</p>
        </div>
      </article>
      <article class="celebration">
        <img src="prototype/assets/images/dish-3.jpg" alt="Wochengericht">
        <div class="luggage-tag" aria-hidden="true">
          <span class="luggage-tag__number">No. 02</span>
          <span class="luggage-tag__label">Vegetarisch</span>
          <span class="luggage-tag__code">GS &middot; VEG</span>
        </div>
        <div class="celebration__body">
          <h3>Ofen-<em>Gem&uuml;se</em></h3>
          <p>Kichererbsen &middot; Tahini &middot; Minze &mdash; 17 &euro;</p>
        </div>
      </article>
      <article class="celebration">
        <img src="prototype/assets/images/dish-1.jpg" alt="Signature Dessert">
        <div class="luggage-tag" aria-hidden="true">
          <span class="luggage-tag__number">No. 03</span>
          <span class="luggage-tag__label">Signature</span>
          <span class="luggage-tag__code">GS &middot; SWT</span>
        </div>
        <div class="celebration__body">
          <h3>Signature-<em>Dessert</em></h3>
          <p>Sanddorn &middot; wei&szlig;e Schokolade &middot; Hafer &mdash; 9 &euro;</p>
        </div>
      </article>
<?php endif; ?>
    </div>
  </div>
</section>

<!-- À la carte Menü -->
<section class="subpage-section subpage-section--cream">
  <div class="wrap">
    <div class="page-head reveal">
      <span class="eyebrow">&Agrave; la carte</span>
      <h2>Unsere <em>Karte</em>.</h2>
      <p>Eine kleine, sorgf&auml;ltig kuratierte Auswahl &mdash; kein endloses Men&uuml;, sondern ausgew&auml;hlte Klassiker und Kreativ-Gerichte. Alle Preise in Euro, inkl. MwSt.</p>
    </div>

    <div class="menu-card reveal">
<?php if (!empty($menuByCategory)): ?>
  <?php foreach ($menuByCategory as $category => $items): ?>
      <div class="menu-card__section">
        <h3 class="menu-card__title"><?= $category ?></h3>
        <ul class="menu-card__list">
          <?php foreach ($items as $item): ?>
          <li><span class="dot"></span><span class="name"><?= h($item['name']) ?></span><span class="leader"></span><span class="price"><?= h($item['price'] ?? '—') ?></span></li>
          <?php endforeach; ?>
        </ul>
      </div>
  <?php endforeach; ?>
<?php else: ?>
      <div class="menu-card__section">
        <h3 class="menu-card__title"><em>Zum</em> Start</h3>
        <ul class="menu-card__list">
          <li><span class="dot"></span><span class="name">Salziger Fischteller</span><span class="leader"></span><span class="price">19</span></li>
          <li><span class="dot"></span><span class="name">Matjes &middot; R&auml;ucherlachs &middot; Nordsee-Krabben &middot; Meerrettich-Cr&egrave;me</span><span class="leader"></span><span class="price">&mdash;</span></li>
          <li><span class="dot"></span><span class="name">Bruchetta mit Tomate, Basilikum &amp; Parmesan</span><span class="leader"></span><span class="price">9</span></li>
          <li><span class="dot"></span><span class="name">K&uuml;rbissuppe mit Sanddorn &amp; K&uuml;rbiskern&ouml;l</span><span class="leader"></span><span class="price">8</span></li>
          <li><span class="dot"></span><span class="name">Rote Bete Carpaccio mit Ziegenk&auml;se &amp; Walnuss</span><span class="leader"></span><span class="price">12</span></li>
        </ul>
      </div>
      <div class="menu-card__section">
        <h3 class="menu-card__title"><em>Aus</em> dem Meer</h3>
        <ul class="menu-card__list">
          <li><span class="dot"></span><span class="name">Pannfisch Holsteiner Art mit Bratkartoffeln &amp; Senfsauce</span><span class="leader"></span><span class="price">22</span></li>
          <li><span class="dot"></span><span class="name">Ostsee-Dorsch auf Salzkartoffel-Stampf &amp; Spinat</span><span class="leader"></span><span class="price">24</span></li>
          <li><span class="dot"></span><span class="name">Scholle &bdquo;Finkenwerder&ldquo; mit Speck, Krabben &amp; Salzkartoffeln</span><span class="leader"></span><span class="price">26</span></li>
          <li><span class="dot"></span><span class="name">Labskaus mit Rollmops, Spiegelei &amp; Gurke</span><span class="leader"></span><span class="price">18</span></li>
        </ul>
      </div>
      <div class="menu-card__section">
        <h3 class="menu-card__title"><em>Vom</em> Land</h3>
        <ul class="menu-card__list">
          <li><span class="dot"></span><span class="name">Holsteiner Burger &middot; Bio-Rind &middot; Cheddar &middot; Bratkartoffeln</span><span class="leader"></span><span class="price">18</span></li>
          <li><span class="dot"></span><span class="name">Kalbsschnitzel Wiener Art mit Kartoffelsalat</span><span class="leader"></span><span class="price">24</span></li>
          <li><span class="dot"></span><span class="name">Rumpsteak 250g mit Ofenkartoffel &amp; Kr&auml;uterbutter</span><span class="leader"></span><span class="price">32</span></li>
          <li><span class="dot"></span><span class="name">Spareribs mit BBQ-Glasur &amp; Coleslaw</span><span class="leader"></span><span class="price">21</span></li>
        </ul>
      </div>
      <div class="menu-card__section">
        <h3 class="menu-card__title"><em>Aus</em> dem Garten</h3>
        <ul class="menu-card__list">
          <li><span class="dot"></span><span class="name">Strandgarten-Bowl &middot; Ofengem&uuml;se &middot; Kichererbsen &middot; Tahini</span><span class="leader"></span><span class="price">17</span></li>
          <li><span class="dot"></span><span class="name">Risotto mit Steinpilzen &amp; gehobeltem Pecorino</span><span class="leader"></span><span class="price">19</span></li>
          <li><span class="dot"></span><span class="name">Gnocchi mit Salbei-Butter &amp; ger&ouml;steten Waln&uuml;ssen</span><span class="leader"></span><span class="price">16</span></li>
        </ul>
      </div>
      <div class="menu-card__section">
        <h3 class="menu-card__title"><em>Zum</em> Abschluss</h3>
        <ul class="menu-card__list">
          <li><span class="dot"></span><span class="name">Cr&egrave;me br&ucirc;l&eacute;e mit Vanille-Bourbon</span><span class="leader"></span><span class="price">8</span></li>
          <li><span class="dot"></span><span class="name">Sanddorn-Parfait mit wei&szlig;er Schokolade</span><span class="leader"></span><span class="price">9</span></li>
          <li><span class="dot"></span><span class="name">Rote Gr&uuml;tze mit Vanillesauce</span><span class="leader"></span><span class="price">7</span></li>
          <li><span class="dot"></span><span class="name">K&auml;se-Auswahl &middot; regionale Sorten mit Fr&uuml;chtebrot</span><span class="leader"></span><span class="price">12</span></li>
        </ul>
      </div>
<?php endif; ?>
    </div>

    <div style="text-align:center; margin-top: 3rem;" class="reveal">
      <a href="kontakt.php" class="btn btn--primary">Tisch reservieren <span class="arrow">&rarr;</span></a>
    </div>
  </div>
</section>

<!-- Philosophie -->
<section class="parallax" data-parallax>
  <div class="parallax__bg" data-parallax-bg style="background-image:url('prototype/assets/images/hero-1.jpg')"></div>
  <div class="parallax__content reveal">
    <span class="eyebrow">Unsere Philosophie</span>
    <h2>Frisch aus der Region.<br><em>Jeden Tag.</em></h2>
    <p>Wir arbeiten mit Kuttern aus der Kieler F&ouml;rde, Bauern aus der Probstei und Winzern aus der Pfalz. Was nicht regional ist, kommt aus direktem Handel. Was nicht saisonal ist, steht nicht auf der Karte.</p>
    <a href="feiern.php" class="btn btn--accent">Eure Feier planen <span class="arrow">&rarr;</span></a>
  </div>
</section>


<?php require 'includes/footer.php'; ?>
</body>
</html>
