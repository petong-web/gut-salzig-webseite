<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/functions.php';
session_start();

$title = "Galerie — gut salzig · Impressionen vom Meer";
$description = "Bilder aus dem gut salzig: Gastraum, Terrasse, Brunch, Küche, Events und Hochzeiten an der Kieler Förde.";
?>
<!doctype html>
<html lang="de">
<head>
<?php require 'includes/head.php'; ?>
</head>
<body>
<?php require 'includes/nav.php'; ?>



<section class="subpage-hero">
  <div class="subpage-hero__media"><img src="prototype/assets/images/hero-1.jpg" alt="Galerie gut salzig"></div>
  <div class="subpage-hero__content">
    <nav class="subpage-hero__breadcrumb"><a href="index.php">Home</a><span class="sep">/</span><span class="current">Galerie</span></nav>
    <span class="subpage-hero__eyebrow">Impressionen</span>
    <h1 class="subpage-hero__title">Momente am<br><em>Meer</em>.</h1>
  </div>
</section>

<section class="subpage-section">
  <div class="wrap-wide">
    <div class="celebrations__grid reveal-stagger">
      <article class="celebration celebration--wide"><img src="prototype/assets/images/hero-1.jpg" alt=""><div class="celebration__body"><h3><em>Gastraum</em> bei Licht</h3><p>Pendel-Leuchten &amp; Pampasgras</p></div></article>
      <article class="celebration"><img src="prototype/assets/images/hero-2.jpg" alt=""><div class="celebration__body"><h3>Die lange <em>Tafel</em></h3><p>Gedeckt f&uuml;r Feiern</p></div></article>
      <article class="celebration"><img src="prototype/assets/images/hero-3.jpg" alt=""><div class="celebration__body"><h3><em>Sommer</em> am Strand</h3><p>Beach Club Vibes</p></div></article>
      <article class="celebration"><img src="prototype/assets/images/hero-4.jpg" alt=""><div class="celebration__body"><h3>Trocken-<em>blumen</em></h3><p>Boho-Details</p></div></article>
      <article class="celebration"><img src="prototype/assets/images/hero-5.jpg" alt=""><div class="celebration__body"><h3>Der <em>Zugang</em></h3><p>Vom Strand ins Restaurant</p></div></article>
      <article class="celebration celebration--wide"><img src="prototype/assets/images/hero-6.jpg" alt=""><div class="celebration__body"><h3>Workshop <em>Shooting</em></h3><p>Hinter den Kulissen</p></div></article>
      <article class="celebration"><img src="prototype/assets/images/hero-7.jpg" alt=""><div class="celebration__body"><h3>Terrassen-<em>Moment</em></h3><p>Goldene Stunde</p></div></article>
      <article class="celebration"><img src="prototype/assets/images/tile-brunch.jpg" alt=""><div class="celebration__body"><h3><em>Brunch</em> Spread</h3><p>Sonntagmorgen</p></div></article>
      <article class="celebration"><img src="prototype/assets/images/tile-alacarte.jpg" alt=""><div class="celebration__body"><h3>&Agrave; la <em>carte</em></h3><p>Auf dem Teller</p></div></article>
    </div>
  </div>
</section>


<?php require 'includes/footer.php'; ?>
</body>
</html>
