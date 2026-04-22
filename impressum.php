<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/functions.php';
session_start();

$title = "Impressum — gut salzig Beach Club & Restaurant";
$description = "Impressum und Anbieterkennzeichnung nach §5 TMG.";
?>
<!doctype html>
<html lang="de">
<head>
<?php require 'includes/head.php'; ?>
</head>
<body>
<?php require 'includes/nav.php'; ?>



<section class="subpage-hero" style="min-height: 42vh;">
  <div class="subpage-hero__media"><img src="prototype/assets/images/hero-3.jpg" alt=""></div>
  <div class="subpage-hero__content">
    <nav class="subpage-hero__breadcrumb"><a href="index.php">Home</a><span class="sep">/</span><span class="current">Impressum</span></nav>
    <h1 class="subpage-hero__title"><em>Impressum</em>.</h1>
  </div>
</section>

<section class="subpage-section">
  <div class="wrap" style="max-width: 780px;">
    <div class="reveal" style="font-size: 0.95rem; line-height: 1.85; color: var(--ink-soft);">
      <h3 style="font-family: var(--ff-display); font-size: 1.6rem; font-weight: 300; font-style: italic; margin-bottom: 1rem;">Angaben gem&auml;&szlig; &sect;5 TMG</h3>
      <p><strong>gut salzig Beach Club &amp; Restaurant</strong><br>Uferkoppel 10<br>24235 Stein<br>Schleswig-Holstein, Deutschland</p>
      <h3 style="font-family: var(--ff-display); font-size: 1.6rem; font-weight: 300; font-style: italic; margin: 2rem 0 1rem;">Kontakt</h3>
      <p>Telefon: 04343 1859155<br>E-Mail: flaschenpost@gut-salzig.de</p>
      <h3 style="font-family: var(--ff-display); font-size: 1.6rem; font-weight: 300; font-style: italic; margin: 2rem 0 1rem;">Umsatzsteuer-ID</h3>
      <p>Umsatzsteuer-Identifikationsnummer gem&auml;&szlig; &sect;27a Umsatzsteuergesetz:<br>[USt-IdNr. hier eintragen]</p>
      <h3 style="font-family: var(--ff-display); font-size: 1.6rem; font-weight: 300; font-style: italic; margin: 2rem 0 1rem;">Verantwortlich f&uuml;r den Inhalt</h3>
      <p>[Name des Verantwortlichen]<br>Uferkoppel 10, 24235 Stein</p>
      <h3 style="font-family: var(--ff-display); font-size: 1.6rem; font-weight: 300; font-style: italic; margin: 2rem 0 1rem;">Streitschlichtung</h3>
      <p>Die Europ&auml;ische Kommission stellt eine Plattform zur Online-Streitbeilegung (OS) bereit. Wir sind nicht bereit oder verpflichtet, an Streitbeilegungsverfahren vor einer Verbraucherschlichtungsstelle teilzunehmen.</p>
    </div>
  </div>
</section>


<?php require 'includes/footer.php'; ?>
</body>
</html>
