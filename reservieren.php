<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/functions.php';
session_start();

$title = "Tisch reservieren — gut salzig · Beach Club & Restaurant";
$description = "Reserviere deinen Tisch direkt online: Brunch, Frühstück, à la carte oder Events bei gut salzig in Stein an der Ostsee.";
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
  <div class="subpage-hero__media"><img src="prototype/assets/images/intro-gastraum.jpg" alt="Reservierung gut salzig"></div>
  <div class="subpage-hero__content">
    <nav class="subpage-hero__breadcrumb"><a href="index.php">Home</a><span class="sep">/</span><span class="current">Reservierung</span></nav>
    <span class="subpage-hero__eyebrow">Online-Reservierung &middot; sofort best&auml;tigt</span>
    <h1 class="subpage-hero__title">Tisch <em>reservieren</em>.</h1>
    <p class="subpage-hero__sub">Such dir Datum und Uhrzeit aus &mdash; in unter 2 Minuten ist dein Tisch gebucht. Best&auml;tigung kommt direkt per E-Mail.</p>
  </div>
  <div class="subpage-hero__bar">
    <span>Uferkoppel 10 &middot; 24235 Stein</span>
    <span class="subpage-hero__bar-flight">GS &middot; BOOKING</span>
    <span>Sofort-Best&auml;tigung</span>
  </div>
</section>

<!-- Resmio Widget Section -->
<section class="subpage-section">
  <div class="wrap" style="max-width: 880px;">

    <div class="page-head reveal">
      <span class="eyebrow">Reservierung</span>
      <h2>Direkt online <em>buchen</em>.</h2>
      <p>Unser Buchungssystem zeigt dir freie Tische in Echtzeit. F&uuml;r gr&ouml;&szlig;ere Gruppen, Hochzeiten oder Firmenfeiern nutze bitte unser <a href="kontakt.php" style="color:var(--accent);text-decoration:underline;">Anfrageformular</a>.</p>
    </div>

    <!-- Resmio Buchungs-Widget -->
    <div class="resmio-wrap reveal">
      <div id="resmio-gut-salzig-beachclub-restaurant"></div>
      <script>(function(d, s) {
        var js, rjs = d.getElementsByTagName(s)[0];
        js = d.createElement(s);
        js.src = "//static.resmio.com/static/de/widget.js#id=gut-salzig-beachclub-restaurant&height=620&width=100%25&fontSize=15px";
        rjs.parentNode.insertBefore(js, rjs);
      }(document, "script"));</script>

      <noscript>
        <p style="text-align:center;padding:2rem;color:var(--ink-soft);">
          Bitte aktiviere JavaScript um zu reservieren, oder <a href="https://app.resmio.com/gut-salzig-beachclub-restaurant/widget" target="_blank" style="color:var(--accent);">öffne die Buchung direkt &uarr;</a>
        </p>
      </noscript>
    </div>

    <p style="text-align:center;font-family:var(--ff-mono);font-size:0.6rem;letter-spacing:0.2em;text-transform:uppercase;color:var(--ink-mute);margin-top:1.5rem;">
      Powered by <a href="https://app.resmio.com/gut-salzig-beachclub-restaurant/widget" target="_blank" style="color:var(--accent);">resmio &middot; Buchungssystem</a>
    </p>

  </div>
</section>

<!-- Info-Sektion: Was wenn das Widget nicht passt -->
<section class="subpage-section subpage-section--cream">
  <div class="wrap" style="max-width: 900px;">
    <div class="page-head reveal">
      <span class="eyebrow">Andere Anliegen</span>
      <h2>Was du sonst noch <em>brauchst</em>.</h2>
    </div>

    <div class="captains-log__grid reveal-stagger">
      <article class="log-entry">
        <span class="log-entry__ribbon">FAQ &middot; 01</span>
        <div class="log-entry__header">
          <h3 class="log-entry__title">Gro&szlig;e <em>Gruppe</em>?</h3>
        </div>
        <p class="log-entry__body">Ab 8 Personen oder f&uuml;r Hochzeiten, Firmenfeiern und Junggesellinnenabschiede schreib uns &uuml;ber das Anfrageformular &mdash; wir planen pers&ouml;nlich mit dir.</p>
        <div class="log-entry__footer">
          <a href="kontakt.php" class="log-entry__signature" style="font-family:var(--ff-mono);font-size:0.6rem;letter-spacing:0.2em;text-transform:uppercase;">Anfrage &rarr;</a>
        </div>
      </article>

      <article class="log-entry">
        <span class="log-entry__ribbon">FAQ &middot; 02</span>
        <div class="log-entry__header">
          <h3 class="log-entry__title">Lieber <em>telefonisch</em>?</h3>
        </div>
        <p class="log-entry__body">Kein Problem &mdash; ruf uns an unter <strong>04343 1859155</strong>. Wir sind w&auml;hrend der &Ouml;ffnungszeiten erreichbar und nehmen deine Reservierung pers&ouml;nlich auf.</p>
        <div class="log-entry__footer">
          <a href="tel:043431859155" class="log-entry__signature" style="font-family:var(--ff-mono);font-size:0.6rem;letter-spacing:0.2em;text-transform:uppercase;">Anrufen &rarr;</a>
        </div>
      </article>

      <article class="log-entry">
        <span class="log-entry__ribbon">FAQ &middot; 03</span>
        <div class="log-entry__header">
          <h3 class="log-entry__title">Reservierung <em>&auml;ndern</em>?</h3>
        </div>
        <p class="log-entry__body">In deiner Best&auml;tigungs-E-Mail findest du einen Link zum &Auml;ndern oder Stornieren. Falls nicht: einfach kurz anrufen, wir helfen sofort.</p>
        <div class="log-entry__footer">
          <a href="mailto:flaschenpost@gut-salzig.de" class="log-entry__signature" style="font-family:var(--ff-mono);font-size:0.6rem;letter-spacing:0.2em;text-transform:uppercase;">Mail &rarr;</a>
        </div>
      </article>
    </div>
  </div>
</section>

<?php require 'includes/footer.php'; ?>
</body>
</html>
