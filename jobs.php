<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/functions.php';
session_start();

$title = "Jobs & Karriere — gut salzig Beach Club & Restaurant · Ostsee";
$description = "Werde Teil unserer Crew: Koch, Service, Event, Strand-Imbiss. Arbeite dort, wo andere Urlaub machen — direkt an der Ostsee in Stein.";

// POST handler for application form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrfCheck();

    $vorname    = trim($_POST['vorname'] ?? '');
    $nachname   = trim($_POST['nachname'] ?? '');
    $email      = trim($_POST['email'] ?? '');
    $phone      = trim($_POST['phone'] ?? '');
    $stelle     = trim($_POST['stelle'] ?? '');
    $erfahrung  = trim($_POST['erfahrung'] ?? '');
    $ort        = trim($_POST['ort'] ?? '');
    $start      = trim($_POST['start'] ?? '');
    $needs      = isset($_POST['needs']) ? implode(', ', $_POST['needs']) : '';
    $motivation = trim($_POST['motivation'] ?? '');

    if ($vorname === '' || $nachname === '' || $email === '') {
        flash('error', 'Bitte fülle mindestens Vorname, Nachname und E-Mail aus.');
    } else {
        dbInsert(
            "INSERT INTO bewerbungen (vorname, nachname, email, phone, stelle, erfahrung, ort, verfuegbar_ab, needs, motivation, created_at)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())",
            [$vorname, $nachname, $email, $phone, $stelle, $erfahrung, $ort, $start ?: null, $needs, $motivation]
        );
        flash('success', 'Herzlichen Dank! Deine Bewerbung ist angekommen — wir melden uns persönlich bei dir.');
        redirect('jobs.php#bewerbung');
    }
}

// Fetch active jobs from DB
$jobs = dbQuery("SELECT * FROM jobs WHERE is_active = 1 ORDER BY sort_order, id");
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
  <div class="subpage-hero__media"><img src="prototype/assets/images/hero-3.jpg" alt="Beach Club im Sommer"></div>
  <div class="subpage-hero__content">
    <nav class="subpage-hero__breadcrumb">
      <a href="index.php">Home</a>
      <span class="sep">/</span>
      <span class="current">Jobs &amp; Karriere</span>
    </nav>
    <span class="subpage-hero__eyebrow">Crew Wanted &middot; Saison 2026</span>
    <h1 class="subpage-hero__title">Werde Teil unserer <em>Crew</em>.</h1>
    <p class="subpage-hero__sub">Arbeite dort, wo andere Urlaub machen &mdash; direkt an der Ostsee im gut salzig Beach Club, Restaurant und Strand-Imbiss in Stein.</p>
  </div>
  <div class="subpage-hero__bar">
    <span>Stein &middot; Ostsee &middot; Schleswig-Holstein</span>
    <span class="subpage-hero__bar-flight">GS &middot; CREW &middot; 2026</span>
    <span><?= count($jobs) ?> offene Stellen</span>
  </div>
</section>

<!-- Warum gut salzig? -->
<section class="subpage-section">
  <div class="wrap">
    <div class="page-head reveal">
      <span class="eyebrow">Warum gut salzig?</span>
      <h2>Nicht nur ein Job &mdash;<br>ein <em>Erlebnis</em>.</h2>
    </div>

    <div class="job-values reveal-stagger">
      <div class="job-value">
        <span class="job-value__icon">&#9728;</span>
        <h3 class="job-value__title">Am Meer arbeiten</h3>
        <p class="job-value__desc">Nur 100 Meter vom naturbelassenen Strand &mdash; ein einzigartiger Ort, der t&auml;glich inspiriert.</p>
      </div>
      <div class="job-value">
        <span class="job-value__icon">&#10022;</span>
        <h3 class="job-value__title">Besondere Location</h3>
        <p class="job-value__desc">Restaurant, Saal, Wintergarten und Strand-Imbiss &mdash; modern, warm und unverwechselbar.</p>
      </div>
      <div class="job-value">
        <span class="job-value__icon">&#9829;</span>
        <h3 class="job-value__title">Echtes Team</h3>
        <p class="job-value__desc">Kein Ellenbogen-Denken. Bei uns arbeiten echte Menschen zusammen, die f&uuml;reinander da sind.</p>
      </div>
      <div class="job-value">
        <span class="job-value__icon">&#9670;</span>
        <h3 class="job-value__title">Vielfalt &amp; Zukunft</h3>
        <p class="job-value__desc">Fr&uuml;hst&uuml;ck, Brunch, Events, Hochzeiten, Imbiss &mdash; immer neue Facetten, immer neue Chancen.</p>
      </div>
    </div>
  </div>
</section>

<!-- Perks -->
<section class="subpage-section subpage-section--cream" style="padding-block: clamp(3rem, 5vw, 5rem);">
  <div class="wrap">
    <div class="page-head reveal" style="margin-bottom: 2rem;">
      <span class="eyebrow">Benefits</span>
      <h2>Was wir <em>bieten</em>.</h2>
    </div>
    <div class="perks reveal">
      <span class="perk"><span class="perk__icon">&#9728;</span>100m zum Strand</span>
      <span class="perk"><span class="perk__icon">&#9673;</span>Unterkunft inklusive</span>
      <span class="perk"><span class="perk__icon">&#10022;</span>Moderne Profik&uuml;che</span>
      <span class="perk"><span class="perk__icon">&#9829;</span>Verpflegung inklusive</span>
      <span class="perk"><span class="perk__icon">&#9670;</span>Faire L&ouml;hne + Trinkgeld</span>
      <span class="perk"><span class="perk__icon">&#9998;</span>Junges Team</span>
      <span class="perk"><span class="perk__icon">&#9733;</span>Flexible Schichten</span>
      <span class="perk"><span class="perk__icon">&#9834;</span>Quereinsteiger willkommen</span>
    </div>
  </div>
</section>

<!-- Offene Stellen -->
<section class="subpage-section" id="stellen">
  <div class="wrap">
    <div class="page-head reveal">
      <span class="eyebrow">Offene Stellen</span>
      <h2>Unsere <em>Abflugtafel</em>.</h2>
      <p>Drei Bereiche, ein Team &mdash; such dir aus, wo du dich am wohlsten f&uuml;hlst.</p>
    </div>

    <div class="job-tabs reveal">
      <button class="job-tab is-active">Alle</button>
      <button class="job-tab">K&uuml;che</button>
      <button class="job-tab">Service &amp; Events</button>
      <button class="job-tab">Strand-Imbiss</button>
    </div>

    <div class="job-cards reveal-stagger">
<?php if (empty($jobs)): ?>
      <p style="text-align:center; color: var(--ink-soft); font-style:italic;">Aktuell keine offenen Stellen. Schau sp&auml;ter wieder vorbei oder schick uns eine Initiativbewerbung!</p>
<?php else: ?>
  <?php foreach ($jobs as $job):
    $tasks = json_decode($job['tasks'] ?? '[]', true) ?: [];
    $meta  = json_decode($job['meta'] ?? '[]', true) ?: [];
    $isInitiativ = !empty($job['is_initiativ']);
  ?>
      <article class="job-card"<?php if ($isInitiativ): ?> style="border-style: dashed;"<?php endif; ?>>
        <?php if (!empty($job['image'])): ?>
        <div class="job-card__photo"><img src="<?= h($job['image']) ?>" alt="<?= h($job['title']) ?>"></div>
        <?php endif; ?>
        <div class="job-card__header"<?php if ($isInitiativ): ?> style="background: var(--accent);"<?php endif; ?>>
          <div class="job-card__brand"><span class="job-card__brand-icon"<?php if ($isInitiativ): ?> style="color:#fff;"<?php endif; ?>>&#9992;</span>GUT SALZIG</div>
          <span class="job-card__dept"<?php if ($isInitiativ): ?> style="color:#fff;"<?php endif; ?>><?= h($job['department'] ?? '') ?></span>
        </div>
        <div class="job-card__body">
          <div class="job-card__title-row">
            <h3 class="job-card__title"><?= $job['title_html'] ?? h($job['title']) ?></h3>
            <span class="job-card__badge"><?= h($job['badge'] ?? 'Vollzeit') ?></span>
          </div>
          <p class="job-card__desc"><?= h($job['description'] ?? '') ?></p>
          <?php if (!empty($meta)): ?>
          <div class="job-card__meta">
            <?php foreach ($meta as $m): ?>
            <div class="job-card__meta-item"><span class="job-card__meta-label"><?= h($m['label'] ?? '') ?></span><span class="job-card__meta-value"><?= h($m['value'] ?? '') ?></span></div>
            <?php endforeach; ?>
          </div>
          <?php endif; ?>
          <?php if (!empty($tasks)): ?>
          <ul class="job-card__tasks">
            <?php foreach ($tasks as $task): ?>
            <li><?= h($task) ?></li>
            <?php endforeach; ?>
          </ul>
          <?php endif; ?>
        </div>
        <div class="job-card__footer">
          <span class="job-card__code"><?= h($job['code'] ?? '') ?></span>
          <a href="#bewerbung" class="job-card__apply">Bewerben &rarr;</a>
        </div>
      </article>
  <?php endforeach; ?>
<?php endif; ?>
    </div>
  </div>
</section>

<!-- Freizeit / After Work -->
<section class="subpage-section subpage-section--cream">
  <div class="wrap">
    <div class="page-head reveal">
      <span class="eyebrow">Nach Feierabend</span>
      <h2>Dein Leben in <em>Stein</em>.</h2>
      <p>Was machst du, wenn die Schicht vorbei ist? Stein an der Ostsee bietet mehr als nur Arbeit.</p>
    </div>
    <div class="lifestyle-grid reveal-stagger">
      <div class="lifestyle-card">
        <img src="prototype/assets/images/life-kite.jpg" alt="Kiten">
        <div class="lifestyle-card__body">
          <h3 class="lifestyle-card__title">Kiten &amp; <em>Windsurfen</em></h3>
          <p class="lifestyle-card__desc">Wind &amp; Wellen vor der T&uuml;r</p>
        </div>
      </div>
      <div class="lifestyle-card">
        <img src="prototype/assets/images/life-sailing.jpg" alt="Segeln">
        <div class="lifestyle-card__body">
          <h3 class="lifestyle-card__title"><em>Segeln</em> am Hafen</h3>
          <p class="lifestyle-card__desc">Kieler F&ouml;rde entdecken</p>
        </div>
      </div>
      <div class="lifestyle-card">
        <img src="prototype/assets/images/life-swim.jpg" alt="Schwimmen">
        <div class="lifestyle-card__body">
          <h3 class="lifestyle-card__title">Schwimmen &amp; <em>Baden</em></h3>
          <p class="lifestyle-card__desc">Naturstrand in 2 Minuten</p>
        </div>
      </div>
      <div class="lifestyle-card">
        <img src="prototype/assets/images/life-surf.jpg" alt="Surfen">
        <div class="lifestyle-card__body">
          <h3 class="lifestyle-card__title"><em>Surf</em>schule</h3>
          <p class="lifestyle-card__desc">Wellenreiten lernen</p>
        </div>
      </div>
      <div class="lifestyle-card">
        <img src="prototype/assets/images/life-golf.jpg" alt="Golf">
        <div class="lifestyle-card__body">
          <h3 class="lifestyle-card__title"><em>Golf</em> spielen</h3>
          <p class="lifestyle-card__desc">10 Minuten entfernt</p>
        </div>
      </div>
      <div class="lifestyle-card">
        <img src="prototype/assets/images/life-bike.jpg" alt="Radfahren">
        <div class="lifestyle-card__body">
          <h3 class="lifestyle-card__title"><em>Radfahren</em></h3>
          <p class="lifestyle-card__desc">Ostseek&uuml;sten-Radweg</p>
        </div>
      </div>
      <div class="lifestyle-card">
        <img src="prototype/assets/images/life-sauna.jpg" alt="Strandsauna">
        <div class="lifestyle-card__body">
          <h3 class="lifestyle-card__title">Strand-<em>sauna</em></h3>
          <p class="lifestyle-card__desc">Schwitzen mit Meerblick</p>
        </div>
      </div>
      <div class="lifestyle-card">
        <img src="prototype/assets/images/life-nature.jpg" alt="Natur">
        <div class="lifestyle-card__body">
          <h3 class="lifestyle-card__title">Natur &amp; <em>Erholung</em></h3>
          <p class="lifestyle-card__desc">Entschleunigung pur</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Bewerbungsformular als Boarding Pass -->
<section class="subpage-section" id="bewerbung">
  <div class="wrap">

    <?= renderFlash() ?>

    <div class="page-head reveal">
      <span class="eyebrow">Jetzt bewerben</span>
      <h2>Dein <em>Boarding Pass</em>.</h2>
      <p>Kein Anschreiben n&ouml;tig &mdash; f&uuml;ll einfach das Formular aus und wir melden uns pers&ouml;nlich bei dir.</p>
    </div>

    <form class="newsletter-pass reveal" method="post" action="jobs.php" style="max-width:1080px; margin-inline:auto;">
      <?= csrfField() ?>

      <div class="newsletter-pass__photo">
        <img src="prototype/assets/images/hero-3.jpg" alt="Beach Club gut salzig">
        <div class="newsletter-pass__photo-overlay">
          <div class="newsletter-pass__photo-top">
            <span class="newsletter-pass__photo-badge">Crew Wanted</span>
            <span class="newsletter-pass__photo-issue">Saison<br>2026</span>
          </div>
          <div class="newsletter-pass__photo-bottom">
            <span class="newsletter-pass__photo-eyebrow">Bewerbung &middot; Application</span>
            <h3 class="newsletter-pass__photo-title">Join the<br><em>Crew</em></h3>
            <dl class="newsletter-pass__photo-meta">
              <div><dt>Location</dt><dd>Stein / STN</dd></div>
              <div><dt>Team</dt><dd>gut salzig</dd></div>
              <div><dt>Start</dt><dd>Flexibel</dd></div>
              <div><dt>Anschreiben</dt><dd>Nicht n&ouml;tig</dd></div>
            </dl>
          </div>
        </div>
      </div>

      <div class="newsletter-pass__main">
        <div class="newsletter-pass__header">
          <div class="newsletter-pass__brand">
            <span class="newsletter-pass__brand-icon">&#9992;</span>
            <span class="newsletter-pass__brand-name">GUT SALZIG</span>
          </div>
          <span class="newsletter-pass__class">Application &middot; Boarding Pass</span>
        </div>

        <div class="newsletter-pass__route">
          <div class="newsletter-pass__route-item">
            <span class="newsletter-pass__route-label">From</span>
            <span class="newsletter-pass__iata">YOU</span>
            <span class="newsletter-pass__city">Dein Standort</span>
          </div>
          <div class="newsletter-pass__arc">
            <svg viewBox="0 0 120 36" preserveAspectRatio="none">
              <path d="M 4 26 Q 60 -6 116 26"/>
              <text x="56" y="12">&#9992;</text>
            </svg>
          </div>
          <div class="newsletter-pass__route-item newsletter-pass__route-item--to">
            <span class="newsletter-pass__route-label">To</span>
            <span class="newsletter-pass__iata">STN</span>
            <span class="newsletter-pass__city">Stein &middot; Ostsee</span>
          </div>
        </div>

        <div class="newsletter-pass__boarding">
          <div class="newsletter-pass__boarding-item">
            <span class="newsletter-pass__boarding-label">Flight</span>
            <span class="newsletter-pass__boarding-value newsletter-pass__boarding-value--accent">GS &middot; CREW</span>
          </div>
          <div class="newsletter-pass__boarding-item">
            <span class="newsletter-pass__boarding-label">Gate</span>
            <span class="newsletter-pass__boarding-value">Beach</span>
          </div>
          <div class="newsletter-pass__boarding-item">
            <span class="newsletter-pass__boarding-label">Group</span>
            <span class="newsletter-pass__boarding-value">A</span>
          </div>
          <div class="newsletter-pass__boarding-item">
            <span class="newsletter-pass__boarding-label">Status</span>
            <span class="newsletter-pass__boarding-value">Open</span>
          </div>
        </div>

        <div class="newsletter-pass__body">
          <div class="newsletter-pass__row">
            <div class="newsletter-pass__field">
              <label for="app-vorname">Vorname</label>
              <input id="app-vorname" name="vorname" type="text" placeholder="Max" required>
            </div>
            <div class="newsletter-pass__field">
              <label for="app-nachname">Nachname</label>
              <input id="app-nachname" name="nachname" type="text" placeholder="Mustermann" required>
            </div>
          </div>
          <div class="newsletter-pass__row">
            <div class="newsletter-pass__field">
              <label for="app-email">E-Mail</label>
              <input id="app-email" name="email" type="email" placeholder="du@beispiel.de" required>
            </div>
            <div class="newsletter-pass__field">
              <label for="app-tel">Telefon</label>
              <input id="app-tel" name="phone" type="tel" placeholder="0170 &hellip;">
            </div>
          </div>
          <div class="newsletter-pass__row">
            <div class="newsletter-pass__field">
              <label for="app-stelle">Stelle</label>
              <select id="app-stelle" name="stelle">
                <option>K&uuml;chenchef (m/w/d)</option>
                <option>Koch / K&uuml;chenhilfe</option>
                <option>Servicekraft</option>
                <option>Eventservice / Hochzeiten</option>
                <option>Fr&uuml;hst&uuml;cksteam</option>
                <option>Koch im Imbiss</option>
                <option>Verkauf &amp; Kasse</option>
                <option>Initiativbewerbung</option>
              </select>
            </div>
            <div class="newsletter-pass__field">
              <label for="app-erfahrung">Erfahrung</label>
              <select id="app-erfahrung" name="erfahrung">
                <option>Ausgebildeter Koch</option>
                <option>Koch mit Berufserfahrung</option>
                <option>K&uuml;chenchef / Sous-Chef</option>
                <option>Serviceerfahrung</option>
                <option>Quereinsteiger mit Erfahrung</option>
                <option>Ohne Erfahrung / Neueinsteiger</option>
              </select>
            </div>
          </div>
          <div class="newsletter-pass__row">
            <div class="newsletter-pass__field">
              <label for="app-ort">Wohnort / Bundesland</label>
              <input id="app-ort" name="ort" type="text" placeholder="z.B. Kiel, SH">
            </div>
            <div class="newsletter-pass__field">
              <label for="app-start">Verf&uuml;gbar ab</label>
              <input id="app-start" name="start" type="date">
            </div>
          </div>

          <span class="newsletter-pass__topics-label">Was brauchst du?</span>
          <div class="newsletter-pass__topics" style="margin-bottom: 1.5rem;">
            <label class="topic">
              <input type="checkbox" name="needs[]" value="unterkunft">
              <span class="topic__check"></span>
              <span class="topic__label">
                <span class="topic__title">Unterkunft</span>
                <span class="topic__desc">Wir helfen bei der Suche</span>
              </span>
            </label>
            <label class="topic">
              <input type="checkbox" name="needs[]" value="vollzeit">
              <span class="topic__check"></span>
              <span class="topic__label">
                <span class="topic__title">Vollzeit</span>
                <span class="topic__desc">Saisonale Festanstellung</span>
              </span>
            </label>
            <label class="topic">
              <input type="checkbox" name="needs[]" value="teilzeit">
              <span class="topic__check"></span>
              <span class="topic__label">
                <span class="topic__title">Teilzeit / Minijob</span>
                <span class="topic__desc">Flexible Stunden</span>
              </span>
            </label>
            <label class="topic">
              <input type="checkbox" name="needs[]" value="ausbildung">
              <span class="topic__check"></span>
              <span class="topic__label">
                <span class="topic__title">Ausbildung</span>
                <span class="topic__desc">Ausbildungsplatz gesucht</span>
              </span>
            </label>
          </div>

          <div class="newsletter-pass__field" style="margin-bottom: 1.5rem;">
            <label for="app-motivation">&Uuml;ber mich / Motivation</label>
            <textarea id="app-motivation" name="motivation" style="min-height:100px; background:transparent; border:0; border-bottom:1px solid rgba(31,20,12,0.25); padding:0.65rem 0; font-family:var(--ff-display); font-style:italic; font-weight:300; font-size:1.05rem; color:var(--ink); resize:vertical;" placeholder="Erz&auml;hl uns kurz von dir&hellip;"></textarea>
          </div>

          <p style="font-size:0.72rem; color:var(--ink-mute); line-height:1.6; margin-bottom:1rem;">
            Mit dem Absenden stimmst du zu, dass wir deine Daten zur Bearbeitung deiner Bewerbung speichern.
            <a href="datenschutz.php" style="color:var(--accent);">Datenschutz</a>
          </p>

          <div class="newsletter-pass__footer">
            <span class="newsletter-pass__pnr">PNR<strong>GS&middot;CREW&middot;2026</strong><br>Wir melden uns pers&ouml;nlich</span>
            <div class="newsletter-pass__barcode" aria-hidden="true"></div>
            <button type="submit" class="newsletter-pass__submit">Bewerbung abschicken <span class="arrow">&rarr;</span></button>
          </div>
        </div>
      </div>
    </form>
  </div>
</section>

<!-- Kontakt -->
<section class="subpage-section subpage-section--cream">
  <div class="wrap" style="text-align: center;">
    <div class="page-head reveal">
      <span class="eyebrow">Fragen?</span>
      <h2>Einfach <em>melden</em>.</h2>
      <p>Ruf uns an oder schreib eine E-Mail &mdash; wir antworten pers&ouml;nlich und schnell.<br>
      <strong>04343 1859155</strong> &middot; <strong>jobs@gut-salzig.de</strong></p>
    </div>
    <a href="kontakt.php" class="btn btn--primary">Kontakt aufnehmen <span class="arrow">&rarr;</span></a>
  </div>
</section>


<?php require 'includes/footer.php'; ?>
</body>
</html>
