<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/functions.php';
session_start();

$title = "Kontakt & Reservierung — gut salzig · Stein an der Ostsee";
$description = "Reserviere deinen Tisch, plane deine Feier oder schick uns eine Postkarte. gut salzig, Uferkoppel 10, 24235 Stein.";

// POST handler for contact form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrfCheck();

    $name    = trim($_POST['name'] ?? '');
    $email   = trim($_POST['email'] ?? '');
    $phone   = trim($_POST['phone'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $date    = trim($_POST['date'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if ($name === '' || $email === '' || $message === '') {
        flash('error', 'Bitte fülle mindestens Name, E-Mail und Nachricht aus.');
    } else {
        dbInsert(
            "INSERT INTO contact_messages (name, email, phone, subject, preferred_date, message, created_at)
             VALUES (?, ?, ?, ?, ?, ?, NOW())",
            [$name, $email, $phone, $subject, $date ?: null, $message]
        );
        flash('success', 'Deine Postkarte ist angekommen! Wir melden uns bald bei dir.');
        redirect('kontakt.php');
    }
}
?>
<!doctype html>
<html lang="de">
<head>
<?php require 'includes/head.php'; ?>
</head>
<body>
<?php require 'includes/nav.php'; ?>



<section class="subpage-hero">
  <div class="subpage-hero__media"><img src="prototype/assets/images/intro-gastraum.jpg" alt="Kontakt gut salzig"></div>
  <div class="subpage-hero__content">
    <nav class="subpage-hero__breadcrumb"><a href="index.php">Home</a><span class="sep">/</span><span class="current">Kontakt</span></nav>
    <span class="subpage-hero__eyebrow">Reservierung &amp; Anfragen</span>
    <h1 class="subpage-hero__title">Besuch uns<br>am <em>Meer</em>.</h1>
    <p class="subpage-hero__sub">Reserviere deinen Tisch f&uuml;r Brunch, Abendessen oder eine Feier. Wir freuen uns auf dich.</p>
  </div>
  <div class="subpage-hero__bar">
    <span>Uferkoppel 10 &middot; 24235 Stein</span>
    <span class="subpage-hero__bar-flight">04343 1859155</span>
    <span>flaschenpost@gut-salzig.de</span>
  </div>
</section>

<section class="contact" style="background: var(--bg);">
  <div class="wrap">

    <?= renderFlash() ?>

    <div class="contact__grid">
      <div class="photo-pair reveal">
        <div class="photo-pair__item"><img src="prototype/assets/images/visit-1.jpg" alt="Brunch-Moment"></div>
        <div class="photo-pair__item"><img src="prototype/assets/images/visit-2.jpg" alt="Gedeckter Tisch"></div>
      </div>
      <div class="reveal">
        <span class="eyebrow">So findest du uns</span>
        <h2>Direkt an<br>der <em>F&ouml;rde</em>.</h2>
        <p>Uferkoppel 10, 24235 Stein. Parkm&ouml;glichkeiten direkt am Restaurant. Mit dem Auto &uuml;ber die B502 Richtung Laboe, Abfahrt Stein.</p>
        <div class="contact__info">
          <div><strong>Adresse</strong><span>Uferkoppel 10<br>24235 Stein</span></div>
          <div><strong>Telefon</strong><span>04343 1859155</span></div>
          <div><strong>E-Mail</strong><span>flaschenpost@<br>gut-salzig.de</span></div>
          <div><strong>Anfahrt</strong><span>B502 &rarr; Stein<br>Parkpl&auml;tze vorhanden</span></div>
        </div>
        <a href="#" class="link" style="margin-top:2rem;">Route planen &rarr;</a>
      </div>
    </div>

    <form class="postcard reveal" method="post" action="kontakt.php">
      <?= csrfField() ?>
      <div class="postcard__header">
        <span class="postcard__greetings">Greetings from <em>Stein</em>,</span>
        <span><strong>POST &middot; GUT SALZIG</strong> &middot; Airmail &middot; Par Avion</span>
      </div>
      <div class="postcard__left">
        <label class="postcard__label" for="pc-msg2">Deine Nachricht</label>
        <textarea id="pc-msg2" name="message" class="postcard__message" placeholder="Hallo gut salzig, ich w&uuml;rde gerne&hellip;"></textarea>
        <div class="postcard__from"><label for="pc-from2">Von:</label><input id="pc-from2" name="from_display" type="text" placeholder="Dein Name"></div>
        <div class="postcard__visa" aria-hidden="true">
          <span class="postcard__visa-top">Entry Visa</span>
          <span class="postcard__visa-main">Cleared</span>
          <span class="postcard__visa-bottom">GS &middot; Stein 2026</span>
        </div>
      </div>
      <div class="postcard__right">
        <div class="postcard__stamp-row">
          <div class="postcard__stamp"><div class="postcard__stamp-inner"><img src="prototype/assets/logo/icon-blk.svg" alt=""><div class="postcard__stamp-value">GS &middot; 0,95</div><div class="postcard__stamp-region">Ostsee &middot; DE</div></div></div>
          <div class="postcard__postmark"><div class="postcard__postmark-city">Stein</div><div class="postcard__postmark-date">Heute</div><div class="postcard__postmark-country">54&deg;26&prime;N &middot; Ostsee</div></div>
        </div>
        <div class="postcard__to">
          <span class="postcard__to-label">An gut salzig &mdash; Absender</span>
          <div class="postcard__to-field"><label>Name</label><input type="text" name="name" placeholder="Max Mustermann" required></div>
          <div class="postcard__to-field"><label>Mail</label><input type="email" name="email" placeholder="du@beispiel.de" required></div>
          <div class="postcard__to-field"><label>Tel</label><input type="tel" name="phone" placeholder="04343 &hellip;"></div>
          <div class="postcard__to-field"><label>Anlass</label><select name="subject"><option>Tischreservierung</option><option>Sonntagsbrunch</option><option>Samstags-Fr&uuml;hst&uuml;ck</option><option>Event-Anfrage</option><option>Hochzeit</option><option>Firmenfeier</option><option>Andere Feier</option></select></div>
          <div class="postcard__to-field"><label>Datum</label><input type="date" name="date"></div>
        </div>
        <button type="submit" class="postcard__send">Postkarte abschicken <span class="arrow">&#9992;</span></button>
      </div>
    </form>
  </div>
</section>


<?php require 'includes/footer.php'; ?>
</body>
</html>
