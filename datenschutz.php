<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/functions.php';
session_start();

$title = "Datenschutz — gut salzig Beach Club & Restaurant";
$description = "Datenschutzerklärung der Website gut-salzig.de.";
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
    <nav class="subpage-hero__breadcrumb"><a href="index.php">Home</a><span class="sep">/</span><span class="current">Datenschutz</span></nav>
    <h1 class="subpage-hero__title"><em>Datenschutz</em>.</h1>
  </div>
</section>

<section class="subpage-section">
  <div class="wrap" style="max-width: 780px;">
    <div class="reveal" style="font-size: 0.95rem; line-height: 1.85; color: var(--ink-soft);">
      <h3 style="font-family: var(--ff-display); font-size: 1.6rem; font-weight: 300; font-style: italic; margin-bottom: 1rem;">1. Datenschutz auf einen Blick</h3>
      <p>Die folgenden Hinweise geben einen einfachen &Uuml;berblick dar&uuml;ber, was mit Ihren personenbezogenen Daten passiert, wenn Sie diese Website besuchen. Personenbezogene Daten sind alle Daten, mit denen Sie pers&ouml;nlich identifiziert werden k&ouml;nnen.</p>
      <h3 style="font-family: var(--ff-display); font-size: 1.6rem; font-weight: 300; font-style: italic; margin: 2rem 0 1rem;">2. Verantwortliche Stelle</h3>
      <p><strong>gut salzig Beach Club &amp; Restaurant</strong><br>Uferkoppel 10, 24235 Stein<br>Telefon: 04343 1859155<br>E-Mail: flaschenpost@gut-salzig.de</p>
      <h3 style="font-family: var(--ff-display); font-size: 1.6rem; font-weight: 300; font-style: italic; margin: 2rem 0 1rem;">3. Datenerfassung auf dieser Website</h3>
      <p>Die Datenverarbeitung auf dieser Website erfolgt durch den Websitebetreiber. Daten werden erhoben, wenn Sie uns diese mitteilen (z.B. &uuml;ber unser Kontaktformular).</p>
      <h3 style="font-family: var(--ff-display); font-size: 1.6rem; font-weight: 300; font-style: italic; margin: 2rem 0 1rem;">4. Hosting</h3>
      <p>[Hosting-Anbieter und Details hier eintragen, sobald die Seite online geht.]</p>
      <h3 style="font-family: var(--ff-display); font-size: 1.6rem; font-weight: 300; font-style: italic; margin: 2rem 0 1rem;">5. Ihre Rechte</h3>
      <p>Sie haben jederzeit das Recht, unentgeltlich Auskunft &uuml;ber Herkunft, Empf&auml;nger und Zweck Ihrer gespeicherten personenbezogenen Daten zu erhalten. Sie haben au&szlig;erdem ein Recht, die Berichtigung oder L&ouml;schung dieser Daten zu verlangen.</p>
      <p style="margin-top: 2rem; color: var(--ink-mute); font-style: italic;">[Hinweis: Diese Datenschutzerkl&auml;rung ist ein Platzhalter. Vor dem Go-Live muss sie durch einen Datenschutzbeauftragten oder Generator erstellt werden.]</p>
    </div>
  </div>
</section>


<?php require 'includes/footer.php'; ?>
</body>
</html>
