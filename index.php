<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/functions.php';
session_start();

$title = "gut salzig — Beach Club & Restaurant · Stein an der Ostsee";
$description = "gut salzig — Beach Club & Restaurant direkt an der Kieler Förde. Deutsche kreative Küche mit Fokus auf Fisch, Sonntagsbrunch, Hochzeiten und Events am Meer.";

// ── Dynamic data ──────────────────────────────────────────
// Brunch: active brunch with menu items
$brunch = dbRow("SELECT * FROM brunch WHERE is_active = 1 ORDER BY week_date DESC LIMIT 1");
$brunchItems = [];
if ($brunch && !empty($brunch['menu_items'])) {
    $brunchItems = json_decode($brunch['menu_items'], true) ?: [];
}

// Kitchen: active tagesgerichte
$tagesgerichte = dbQuery("SELECT * FROM tagesgerichte WHERE is_active = 1 ORDER BY sort_order LIMIT 3");

// Events: upcoming events
$events = dbQuery(
    "SELECT * FROM events WHERE is_active = 1 AND event_date >= CURDATE() ORDER BY event_date LIMIT 4",
    []
);

// Captain's Log: latest published blog posts
$logEntries = dbQuery("SELECT * FROM blog_posts WHERE is_published = 1 ORDER BY published_at DESC LIMIT 3");
?>
<!doctype html>
<html lang="de">
<head>
<?php require 'includes/head.php'; ?>
</head>
<body>

<!-- =========================================================
     MINIMAL NAVIGATION
     ========================================================= -->
<header class="nav" id="nav">
  <div class="nav__inner">
    <a href="#top" class="nav__brand" aria-label="gut salzig">
      <img src="prototype/assets/logo/logo2-wht.svg" alt="gut salzig" class="logo-wht">
      <img src="prototype/assets/logo/logo2-blk.svg" alt="" class="logo-blk" aria-hidden="true">
    </a>

    <nav class="nav__menu">
      <a href="#angebot">Angebot</a>
      <a href="#kueche">K&uuml;che</a>
      <a href="#brunch">Brunch</a>
      <a href="#events">Events</a>
      <a href="#feiern">Feiern</a>
      <a href="#galerie">Galerie</a>
      <a href="#kontakt">Kontakt</a>
    </nav>

    <div class="nav__right">
      <a href="tel:043431859155" class="nav__phone">04343 1859155</a>
      <a href="#kontakt" class="nav__reserve">Reservieren</a>
      <button class="nav__burger" id="navBurger" aria-label="Men&uuml; &ouml;ffnen">
        <span></span><span></span>
      </button>
    </div>
  </div>
</header>

<!-- =========================================================
     FULLSCREEN OVERLAY MENU
     ========================================================= -->
<div class="menu" id="menu">
  <div class="menu__top">
    <div class="menu__brand">
      <img src="prototype/assets/logo/logo2-blk.svg" alt="gut salzig" style="height:44px;width:auto;">
    </div>
    <button class="menu__close" id="menuClose" aria-label="Men&uuml; schlie&szlig;en">&times;</button>
  </div>

  <div class="menu__grid">
    <ul class="menu__list">
      <li><a href="#angebot"      data-num="01">Angebot</a></li>
      <li><a href="#kueche"       data-num="02">K&uuml;che</a></li>
      <li><a href="#brunch"       data-num="03">Sonntagsbrunch</a></li>
      <li><a href="#events"       data-num="04">Events</a></li>
      <li><a href="#feiern"       data-num="05">Hochzeiten &amp; Feiern</a></li>
      <li><a href="#galerie"      data-num="06">Galerie</a></li>
      <li><a href="#kontakt"      data-num="07">Kontakt</a></li>
    </ul>

    <aside class="menu__aside">
      <h4>Besuch uns</h4>
      <p>Direkt an der Kieler F&ouml;rde.<br>Uferkoppel 10, 24235 Stein</p>
      <div class="hours">
        <span><strong>Do&ndash;Fr</strong> 17 &ndash; 20 Uhr</span>
        <span><strong>Sa</strong> Fr&uuml;hst&uuml;ck ab 09 &middot; bis 20 Uhr</span>
        <span><strong>So</strong> Brunch 10 &ndash; 14 &middot; bis 20 Uhr</span>
      </div>
      <a href="tel:043431859155" class="link">04343 1859155 &rarr;</a>
    </aside>
  </div>

  <div class="menu__bottom">
    <span>&copy; 2026 gut salzig</span>
    <div class="menu__social">
      <a href="#">Instagram</a>
      <a href="#">Facebook</a>
      <a href="#">Google</a>
    </div>
  </div>
</div>

<!-- =========================================================
     HERO — Full-bleed
     ========================================================= -->
<section class="hero" id="top">
  <div class="hero__media" id="heroMedia">
    <div class="hero__slide is-active">
      <img src="prototype/assets/images/hero-1.jpg" alt="Gastraum mit Pendel-Leuchten">
    </div>
    <div class="hero__slide">
      <img src="prototype/assets/images/hero-6.jpg" alt="Workshop-Stimmung">
    </div>
    <div class="hero__slide">
      <img src="prototype/assets/images/hero-2.jpg" alt="Gedeckte Tische">
    </div>
    <div class="hero__slide">
      <img src="prototype/assets/images/hero-7.jpg" alt="Workshop-Moment">
    </div>
    <div class="hero__slide">
      <img src="prototype/assets/images/hero-3.jpg" alt="Sommer am Strand">
    </div>
    <div class="hero__slide">
      <img src="prototype/assets/images/hero-4.jpg" alt="Gastraum mit Trockenblumen">
    </div>
    <div class="hero__slide">
      <img src="prototype/assets/images/hero-5.jpg" alt="Strandzugang">
    </div>
  </div>

  <div class="hero__content">
    <div class="hero__eyebrow">Beach Club &middot; Restaurant &middot; Eventlocation</div>
    <h1 class="hero__title">
      &hellip;wie ein Tag<br><em>Urlaub</em> am Meer.
    </h1>
    <p class="hero__sub">Deutsche Kreativ-K&uuml;che, Sonntagsbrunch und Feiern &mdash; direkt an der Kieler F&ouml;rde.<br>Ankommen. Genie&szlig;en. Entschleunigen.</p>
    <div class="hero__actions">
      <a href="#kontakt" class="btn btn--accent">Tisch reservieren <span class="arrow">&rarr;</span></a>
      <a href="#angebot" class="btn btn--ghost">Entdecken</a>
    </div>
  </div>

  <div class="hero__bar">
    <div class="hero__coords">54&deg;26&prime;N &middot; 10&deg;14&prime;E &middot; Stein</div>
    <div class="hero__dots" id="heroDots"></div>
    <div class="hero__scroll">scroll</div>
  </div>
</section>

<!-- =========================================================
     ANGEBOT — 3 große quadratische Kacheln
     ========================================================= -->
<section class="tiles" id="angebot">
  <div class="tiles__header reveal">
    <span class="eyebrow">Was uns ausmacht</span>
    <h2>Drei Welten,<br>ein <em>Ort</em>.</h2>
    <p>Von sonnigen Sonntagsbrunches &uuml;ber kreative Abendk&uuml;che bis zu unvergesslichen Feiern am Wasser &mdash; jede Kachel &ouml;ffnet eine eigene Geschichte.</p>
  </div>

  <div class="tiles__grid reveal-stagger">
    <a href="brunch.php" class="tile">
      <img src="prototype/assets/images/tile-brunch.jpg" alt="Fr&uuml;hst&uuml;ck &amp; Brunch">
      <div class="tile__num">01</div>
      <div class="tile__inner">
        <div class="tile__kicker">Samstag &amp; Sonntag</div>
        <h3 class="tile__title">Fr&uuml;hst&uuml;ck &amp;<br><em>Brunch</em></h3>
        <p class="tile__desc">Samstag: Fr&uuml;hst&uuml;ck &agrave; la carte. Sonntag: gro&szlig;er Brunch mit w&ouml;chentlich wechselndem Men&uuml;.</p>
        <span class="tile__arrow">Entdecken</span>
      </div>
    </a>

    <a href="kueche.php" class="tile">
      <img src="prototype/assets/images/tile-alacarte.jpg" alt="&Agrave; la carte">
      <div class="tile__num">02</div>
      <div class="tile__inner">
        <div class="tile__kicker">Do &ndash; So</div>
        <h3 class="tile__title">&Agrave; la <em>carte</em></h3>
        <p class="tile__desc">Deutsche kreative K&uuml;che. Fisch aus heimischen Gew&auml;ssern. Tagesaktuelle Gerichte.</p>
        <span class="tile__arrow">Speisekarte</span>
      </div>
    </a>

    <a href="feiern.php" class="tile">
      <img src="prototype/assets/images/tile-feiern.jpg" alt="Feiern &amp; Events">
      <div class="tile__num">03</div>
      <div class="tile__inner">
        <div class="tile__kicker">Hochzeiten &middot; Firmenfeiern</div>
        <h3 class="tile__title">Feiern &amp;<br><em>Events</em></h3>
        <p class="tile__desc">Eure Feier am Meer. Von intim bis gro&szlig;, von Familie bis Firma.</p>
        <span class="tile__arrow">Anfragen</span>
      </div>
    </a>
  </div>
</section>

<!-- =========================================================
     INTRO — Editorial Split
     ========================================================= -->
<section class="intro">
  <div class="wrap">
    <div class="intro__grid">
      <div class="intro__media reveal">
        <img class="img-1" src="prototype/assets/images/intro-gastraum.jpg" alt="Gastraum">
        <img class="img-2" src="prototype/assets/images/intro-food.jpg" alt="Kreative K&uuml;che">
      </div>
      <div class="intro__text reveal">
        <span class="eyebrow">Unsere Geschichte</span>
        <h2>Ein Ort, der nach <em>Meer</em> schmeckt.</h2>
        <p>Im gut salzig verbinden wir zwei Welten: die Gelassenheit eines Beach Clubs und die Sorgfalt einer K&uuml;che, die auf beste regionale Zutaten setzt &mdash; mit einem Herz f&uuml;r Fisch aus heimischen Gew&auml;ssern.</p>
        <p>Umgeben von Treibholz, Kerzen und dem Duft von Salz und Kr&auml;utern wird jeder Abend zu einem kleinen Urlaub. Tags&uuml;ber Brunch, abends Kerzen, dazwischen Geschichten.</p>
        <div class="intro__signature">
          <span class="intro__signature-line"></span>
          <span class="intro__signature-text">Euer gut&nbsp;salzig Team</span>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- =========================================================
     BRUNCH (dynamic)
     ========================================================= -->
<section class="brunch" id="brunch">
  <div class="wrap">
    <div class="brunch__grid">
      <div class="brunch__content reveal">
        <span class="eyebrow">Fr&uuml;hst&uuml;ck &amp; Brunch</span>
        <h2>Das sch&ouml;nste Fr&uuml;hst&uuml;ck<br>der <em>Woche</em>.</h2>
        <p>Bei uns beginnt das Wochenende entspannt: Samstags gibt es gem&uuml;tliches Fr&uuml;hst&uuml;ck &agrave; la carte, sonntags unseren gro&szlig;en Brunch mit w&ouml;chentlich wechselndem Men&uuml;, frischem Brot, Fisch, K&auml;se und vielen Kleinigkeiten zum Probieren.</p>

        <div class="brunch__days">
          <div class="brunch__day">
            <div class="brunch__day-label">Samstag</div>
            <div class="brunch__day-title">Fr&uuml;hst&uuml;ck<br>&agrave; la carte</div>
            <div class="brunch__day-meta">Ab 09:00 Uhr &middot; aus der Karte bestellen</div>
          </div>
          <div class="brunch__day brunch__day--highlight">
            <div class="brunch__day-label">Sonntag</div>
            <div class="brunch__day-title">Brunch-<br>Buffet</div>
            <div class="brunch__day-meta">10 &ndash; 14 Uhr &middot; <?= $brunch ? h($brunch['price'] ?? '29') : '29' ?> &euro; p. P. &middot; w&ouml;chentlich neu</div>
          </div>
        </div>

        <span class="brunch__menu-label">Diesen Sonntag auf dem Tisch</span>
        <ul class="brunch__menu">
<?php if (!empty($brunchItems)): ?>
  <?php foreach ($brunchItems as $i => $item): ?>
          <li data-n="<?= str_pad($i + 1, 2, '0', STR_PAD_LEFT) ?>"><?= h($item) ?></li>
  <?php endforeach; ?>
<?php else: ?>
          <li data-n="01">Haus&shy;ger&auml;ucherter Lachs mit Dill &amp; Roggen-Sauerteig</li>
          <li data-n="02">Pochierte Eier auf jungem Spinat, Sauce Hollandaise</li>
          <li data-n="03">Nordsee-Krabben auf R&uuml;hrei mit Schnittlauch</li>
          <li data-n="04">Granola mit Ostsee-Honig &amp; frischen Beeren</li>
          <li data-n="05">Regionale K&auml;se-Auswahl &amp; warme Buchteln</li>
<?php endif; ?>
        </ul>

        <a href="brunch.php" class="btn btn--primary">Platz reservieren <span class="arrow">&rarr;</span></a>
      </div>
      <div class="brunch__image reveal">
        <span class="brunch__badge">Live &middot; jeden Sonntag neu</span>
        <?php if ($brunch && !empty($brunch['image'])): ?>
        <img src="<?= h($brunch['image']) ?>" alt="Sonntagsbrunch">
        <?php else: ?>
        <img src="prototype/assets/images/brunch-vertical.jpg" alt="Sonntagsbrunch">
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>

<!-- =========================================================
     PARALLAX CALLOUT
     ========================================================= -->
<section class="parallax" data-parallax>
  <div class="parallax__bg" data-parallax-bg style="background-image:url('prototype/assets/images/hero-3.jpg')"></div>
  <div class="parallax__content reveal">
    <span class="eyebrow">Direkt am Wasser</span>
    <h2>Essen, wo der<br><em>Horizont</em> beginnt.</h2>
    <p>Unsere Terrasse liegt nur wenige Schritte vom Wasser entfernt. Bei Sonnenuntergang wird das Meer zu einem Teil der Speisekarte.</p>
    <a href="#kontakt" class="btn btn--accent">Jetzt reservieren <span class="arrow">&rarr;</span></a>
  </div>
</section>

<!-- Flight arc divider -->
<div class="flight-divider" aria-hidden="true">
  <svg viewBox="0 0 1200 80" preserveAspectRatio="none">
    <path d="M 40 50 Q 600 -20 1160 50"/>
  </svg>
  <span class="flight-divider__plane">&#9992;</span>
</div>

<!-- =========================================================
     KÜCHE / TAGESGERICHTE (dynamic)
     ========================================================= -->
<section class="kitchen" id="kueche" style="background: var(--bg);">
  <div class="wrap">
    <div class="section-head reveal">
      <h2>Aus unserer<br><em>K&uuml;che</em>.</h2>
      <p>W&ouml;chentlich wechselnde Tagesgerichte, eine sorgf&auml;ltig kuratierte &Agrave;-la-carte-Karte und saisonale Spezilit&auml;ten. Deutsche Kreativ-K&uuml;che mit Fokus auf Fisch aus heimischen Gew&auml;ssern &mdash; frisch, ehrlich, mit einer Prise Salz.</p>
    </div>

    <div class="celebrations__grid reveal-stagger">
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
          <p><?= h($dish['description'] ?? '') ?></p>
        </div>
      </article>
  <?php endforeach; ?>
<?php else: ?>
      <article class="celebration">
        <img src="prototype/assets/images/dish-1.jpg" alt="Signature-Dessert">
        <div class="luggage-tag" aria-hidden="true">
          <span class="luggage-tag__number">No. 01</span>
          <span class="luggage-tag__label">Dessert</span>
          <span class="luggage-tag__code">GS &middot; SWT</span>
        </div>
        <div class="celebration__body">
          <h3>Signature-<em>Dessert</em></h3>
          <p>S&uuml;&szlig;er Abschluss</p>
        </div>
      </article>
      <article class="celebration">
        <img src="prototype/assets/images/dish-2.jpg" alt="Tagesgericht">
        <div class="luggage-tag" aria-hidden="true">
          <span class="luggage-tag__number">No. 02</span>
          <span class="luggage-tag__label">&Agrave; la carte</span>
          <span class="luggage-tag__code">GS &middot; MAIN</span>
        </div>
        <div class="celebration__body">
          <h3><em>Tages</em>gericht</h3>
          <p>Kreativ-K&uuml;che</p>
        </div>
      </article>
      <article class="celebration">
        <img src="prototype/assets/images/dish-3.jpg" alt="Brunch-Teller">
        <div class="luggage-tag" aria-hidden="true">
          <span class="luggage-tag__number">No. 03</span>
          <span class="luggage-tag__label">Brunch</span>
          <span class="luggage-tag__code">GS &middot; SUN</span>
        </div>
        <div class="celebration__body">
          <h3>Brunch-<em>Teller</em></h3>
          <p>Herzhaft &amp; s&uuml;&szlig;</p>
        </div>
      </article>
<?php endif; ?>
    </div>

    <div style="text-align:center; margin-top: 4rem;" class="reveal">
      <a href="kueche.php" class="btn btn--outline">Komplette Speisekarte <span class="arrow">&rarr;</span></a>
    </div>
  </div>
</section>

<!-- Flight arc divider -->
<div class="flight-divider flight-divider--on-cream" aria-hidden="true">
  <svg viewBox="0 0 1200 80" preserveAspectRatio="none">
    <path d="M 40 50 Q 600 -20 1160 50"/>
  </svg>
  <span class="flight-divider__plane">&#9992;</span>
</div>

<!-- =========================================================
     EVENTS (dynamic)
     ========================================================= -->
<section class="events" id="events">
  <div class="wrap">
    <div class="section-head reveal">
      <h2>Unsere<br><em>Abflugtafel</em>.</h2>
      <p>Vier Flights Richtung Wochenende. Von Sommer-Er&ouml;ffnungsfest &uuml;ber Weinabende bis Beach-Yoga &mdash; jedes Event ein eigener kleiner Urlaub am Meer. Einchecken bitte rechtzeitig.</p>
      <div class="passport-stamp" aria-hidden="true">
        <span class="passport-stamp__top">Departures</span>
        <span class="passport-stamp__divider"></span>
        <span class="passport-stamp__main">STN</span>
        <span class="passport-stamp__divider"></span>
        <span class="passport-stamp__bottom">2026 &middot; Ostsee</span>
      </div>
    </div>

    <div class="departure-board reveal">
      <div class="departure-board__label"><span class="departure-board__dot"></span>LIVE &middot; GUT SALZIG DEPARTURES</div>
      <div class="departure-board__marquee">NEXT DESTINATIONS &middot; STEIN &rarr; ENTSCHLEUNIGUNG</div>
      <div class="departure-board__clock" id="gsClock">&mdash;&mdash; :&mdash;&mdash;</div>
    </div>

    <form class="flight-search reveal" onsubmit="event.preventDefault();">
      <div class="flight-search__field">
        <label class="flight-search__label">Departure</label>
        <div class="flight-search__value flight-search__value--static">Stein &middot; STN</div>
      </div>
      <div class="flight-search__arrow">&#9992;</div>
      <div class="flight-search__field">
        <label class="flight-search__label">Destination</label>
        <select class="flight-search__value">
          <option>Alle Events</option>
<?php foreach ($events as $ev): ?>
          <option><?= h($ev['title']) ?></option>
<?php endforeach; ?>
        </select>
      </div>
      <div class="flight-search__field">
        <label class="flight-search__label">Monat</label>
        <select class="flight-search__value">
          <option>Alle Monate</option>
          <option>Juni 2026</option>
          <option>Juli 2026</option>
          <option>August 2026</option>
          <option>September 2026</option>
          <option>Oktober 2026</option>
        </select>
      </div>
      <div class="flight-search__field">
        <label class="flight-search__label">Kategorie</label>
        <select class="flight-search__value">
          <option>Alle Kategorien</option>
          <option>Party</option>
          <option>Live Musik</option>
          <option>Workshop</option>
          <option>Buffet</option>
          <option>Feiertag</option>
          <option>Komedie</option>
          <option>Lesung</option>
        </select>
      </div>
      <button type="submit" class="flight-search__submit">Suchen <span class="arrow">&rarr;</span></button>
    </form>

    <div class="tickets reveal-stagger">
<?php if (!empty($events)): ?>
  <?php foreach ($events as $ev):
    $pnr = generatePNR($ev['event_date']);
    $dateFormatted = strtoupper(date('d M y', strtotime($ev['event_date'])));
    $timeFormatted = !empty($ev['event_time']) ? formatTime($ev['event_time']) : '';
    $iataCode = strtoupper(substr($ev['slug'] ?? slugify($ev['title']), 0, 3));

    $statusClass = 'ticket__status--info';
    $statusLabel = 'Free';
    $bookLabel = 'Anmelden';
    if (!empty($ev['ticket_type'])) {
        if ($ev['ticket_type'] === 'ticket') {
            $statusClass = 'ticket__status--ticket';
            $statusLabel = 'Ticket';
            $bookLabel = 'Buchen';
        } elseif ($ev['ticket_type'] === 'reserve') {
            $statusClass = 'ticket__status--reserve';
            $statusLabel = 'Reserve';
            $bookLabel = 'Reservieren';
        }
    }
    $priceDisplay = !empty($ev['price']) ? h($ev['price']) . ' &euro;' : 'Free';
  ?>

      <article class="ticket">
        <div class="ticket__photo">
          <?php if (!empty($ev['image'])): ?>
          <img src="<?= h($ev['image']) ?>" alt="<?= h($ev['title']) ?>">
          <?php else: ?>
          <img src="prototype/assets/images/event-1.jpg" alt="<?= h($ev['title']) ?>">
          <?php endif; ?>
          <div class="ticket__tags">
            <span class="ticket__status <?= $statusClass ?>"><?= $statusLabel ?></span>
            <?php if (!empty($ev['category'])): ?>
            <span class="ticket__category"><span class="ticket__category-icon"><?= h($ev['category_icon'] ?? '&#9834;') ?></span><?= h($ev['category']) ?></span>
            <?php endif; ?>
          </div>
        </div>
        <div class="ticket__body">
          <div class="ticket__airline">
            <div class="ticket__brand"><span class="ticket__brand-icon">&#9992;</span><span class="ticket__brand-name">GUT SALZIG</span></div>
            <small>Boarding Pass</small>
          </div>
          <div class="ticket__route">
            <div class="ticket__route-item">
              <span class="ticket__iata">STN</span>
              <span class="ticket__city">Stein &middot; F&ouml;rde</span>
            </div>
            <div class="ticket__arc">
              <svg viewBox="0 0 80 28" preserveAspectRatio="none">
                <path d="M 2 22 Q 40 -4 78 22"/>
                <text x="37" y="10">&#9992;</text>
              </svg>
            </div>
            <div class="ticket__route-item ticket__route-item--to">
              <span class="ticket__iata"><?= h($iataCode) ?></span>
              <span class="ticket__city"><?= h($ev['title']) ?></span>
            </div>
          </div>
          <div class="ticket__meta">
            <div class="ticket__meta-item"><span class="ticket__meta-label">Date</span><span class="ticket__meta-value"><?= $dateFormatted ?></span></div>
            <div class="ticket__meta-item"><span class="ticket__meta-label">Depart</span><span class="ticket__meta-value"><?= $timeFormatted ?></span></div>
            <?php if (!empty($ev['meta_label']) && !empty($ev['meta_value'])): ?>
            <div class="ticket__meta-item"><span class="ticket__meta-label"><?= h($ev['meta_label']) ?></span><span class="ticket__meta-value"><?= h($ev['meta_value']) ?></span></div>
            <?php endif; ?>
            <div class="ticket__meta-item"><span class="ticket__meta-label">Class</span><span class="ticket__meta-value ticket__meta-value--accent"><?= $priceDisplay ?></span></div>
          </div>
          <div class="ticket__footer">
            <div class="ticket__footer-left">
              <span class="ticket__pnr">PNR <strong><?= h($pnr) ?></strong></span>
              <div class="ticket__share">
                <span class="ticket__share-label">Share</span>
                <a href="mailto:?subject=<?= urlencode($ev['title']) ?>%20bei%20gut%20salzig" class="ticket__share-btn" aria-label="Per E-Mail teilen"><svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M3 6l9 7 9-7v12H3V6z"/><path d="M3 6l9 7 9-7"/></svg></a>
                <a href="https://wa.me/?text=<?= urlencode($ev['title']) ?>" class="ticket__share-btn" aria-label="Per WhatsApp teilen"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2a10 10 0 00-8.6 15l-1.4 5 5.1-1.3A10 10 0 1012 2zm4.4 12.4c-.2-.1-1.4-.7-1.6-.8-.2-.1-.4-.1-.5.1l-.7.9c-.1.2-.3.2-.5.1a6.5 6.5 0 01-3.2-2.8c-.2-.4.2-.4.6-1.2.1-.1 0-.3 0-.4l-.7-1.8c-.2-.4-.4-.4-.5-.4h-.5c-.2 0-.5.1-.7.3s-.9.9-.9 2.1.9 2.4 1 2.6c.1.2 1.8 2.8 4.5 3.9 1.6.7 2.2.8 3 .6.5-.1 1.4-.6 1.6-1.1.2-.6.2-1 .2-1.1-.1-.1-.3-.2-.5-.3z"/></svg></a>
                <a href="https://www.facebook.com/sharer/sharer.php?u=" class="ticket__share-btn" aria-label="Auf Facebook teilen"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M22 12a10 10 0 10-11.6 9.9v-7H8V12h2.4V9.8c0-2.4 1.4-3.7 3.6-3.7 1 0 2.1.2 2.1.2v2.3H15c-1.2 0-1.5.7-1.5 1.5V12h2.6l-.4 2.9h-2.2v7A10 10 0 0022 12z"/></svg></a>
                <a href="https://www.instagram.com/" class="ticket__share-btn" aria-label="Auf Instagram teilen"><svg viewBox="0 0 24 24" fill="none" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="0.6" fill="currentColor"/></svg></a>
              </div>
            </div>
            <a href="kontakt.php" class="ticket__book"><?= $bookLabel ?> <span class="arrow">&rarr;</span></a>
          </div>
        </div>
      </article>
  <?php endforeach; ?>
<?php else: ?>
      <!-- Fallback static events when DB is empty -->
      <p style="text-align:center; color: var(--ink-soft); font-style:italic; padding: 2rem 0;">Neue Events werden bald ver&ouml;ffentlicht!</p>
<?php endif; ?>
    </div>

    <div style="text-align:center; margin-top: 4rem; position: relative; z-index: 2;" class="reveal">
      <a href="events.php" class="btn btn--outline">Alle Flights ansehen <span class="arrow">&rarr;</span></a>
    </div>
  </div>
</section>

<!-- =========================================================
     FEIERN & HOCHZEITEN
     ========================================================= -->
<section class="celebrations" id="feiern">
  <div class="wrap-wide">
    <div class="section-head reveal">
      <h2>Eure Feier.<br><em>Unser</em> Meer.</h2>
      <p>Ob kleine Familienfeier oder gro&szlig;e Hochzeit mit 120 G&auml;sten &mdash; wir machen eure Feier zu etwas Besonderem. Mit einer Location direkt an der Ostsee, die in Erinnerung bleibt.</p>
      <div class="passport-stamp" aria-hidden="true">
        <span class="passport-stamp__top">Entry Visa</span>
        <span class="passport-stamp__divider"></span>
        <span class="passport-stamp__main">Feiern</span>
        <span class="passport-stamp__divider"></span>
        <span class="passport-stamp__bottom">Approved &middot; GS</span>
      </div>
    </div>

    <div class="celebrations__grid reveal-stagger">
      <article class="celebration celebration--wide">
        <img src="prototype/assets/images/cel-hochzeit.jpg" alt="Hochzeit am Meer">
        <div class="celebration__body">
          <h3><em>Hochzeiten</em> am Meer</h3>
          <p>Das Ja-Wort am Wasser</p>
        </div>
      </article>
      <article class="celebration">
        <img src="prototype/assets/images/cel-firmenfeier.jpg" alt="Firmenfeier">
        <div class="celebration__body">
          <h3>Firmen-<em>feiern</em></h3>
          <p>Team-Events &amp; Incentives</p>
        </div>
      </article>
      <article class="celebration">
        <img src="prototype/assets/images/cel-jga.jpg" alt="Junggesellinnenabschied">
        <div class="celebration__body">
          <h3><em>Junggesellen</em>abschied</h3>
          <p>Der Tag vor dem Tag</p>
        </div>
      </article>
      <article class="celebration">
        <img src="prototype/assets/images/cel-weihnachten.jpg" alt="Weihnachtsfeier">
        <div class="celebration__body">
          <h3><em>Weihnachts</em>feier</h3>
          <p>Festliche Abende</p>
        </div>
      </article>
      <article class="celebration">
        <img src="prototype/assets/images/cel-baby.jpg" alt="Babyparty">
        <div class="celebration__body">
          <h3><em>Baby</em>party</h3>
          <p>Liebevolle Momente</p>
        </div>
      </article>
      <article class="celebration">
        <img src="prototype/assets/images/cel-konfirmation.jpg" alt="Konfirmation">
        <div class="celebration__body">
          <h3><em>Konfirmation</em></h3>
          <p>Familienfest am Wasser</p>
        </div>
      </article>
    </div>
  </div>
</section>

<!-- Flight arc divider -->
<div class="flight-divider" aria-hidden="true">
  <svg viewBox="0 0 1200 80" preserveAspectRatio="none">
    <path d="M 40 50 Q 600 -20 1160 50"/>
  </svg>
  <span class="flight-divider__plane">&#9992;</span>
</div>

<!-- =========================================================
     GALLERY STRIP
     ========================================================= -->
<section class="gallery-strip" id="galerie">
  <div class="gallery-strip__head reveal">
    <h2>Momente am<br><em>Meer</em>.</h2>
    <a href="galerie.php" class="link">Alle Bilder &rarr;</a>
  </div>
  <div class="gallery-strip__track">
    <div class="gallery-strip__item"><img src="prototype/assets/images/gal-1.jpg" alt=""><span class="gallery-strip__label">Wintergarten</span></div>
    <div class="gallery-strip__item"><img src="prototype/assets/images/gal-2.jpg" alt=""><span class="gallery-strip__label">Gastraum</span></div>
    <div class="gallery-strip__item"><img src="prototype/assets/images/gal-3.jpg" alt=""><span class="gallery-strip__label">Brunch-Moment</span></div>
    <div class="gallery-strip__item"><img src="prototype/assets/images/gal-4.jpg" alt=""><span class="gallery-strip__label">Sonntag</span></div>
    <div class="gallery-strip__item"><img src="prototype/assets/images/gal-5.jpg" alt=""><span class="gallery-strip__label">Kaffee &amp; Kuchen</span></div>
    <div class="gallery-strip__item"><img src="prototype/assets/images/gal-6.jpg" alt=""><span class="gallery-strip__label">Tisch</span></div>
    <div class="gallery-strip__item"><img src="prototype/assets/images/gal-7.jpg" alt=""><span class="gallery-strip__label">Impression</span></div>
  </div>
</section>

<!-- =========================================================
     CAPTAIN'S LOG — Journal News (dynamic)
     ========================================================= -->
<section class="captains-log">
  <div class="wrap">
    <div class="section-head reveal">
      <h2>Captain's<br><em>Log</em>.</h2>
      <p>Kleine Eintr&auml;ge aus dem Logbuch &mdash; was heute in der K&uuml;che passiert, was morgen auf den Tisch kommt und was das Meer an Geschichten ansp&uuml;lt.</p>
    </div>

    <div class="captains-log__grid reveal-stagger">
<?php if (!empty($logEntries)): ?>
  <?php foreach ($logEntries as $i => $entry):
    $entryNum = str_pad(($entry['entry_number'] ?? (42 - $i)), 3, '0', STR_PAD_LEFT);
    $pubDate = !empty($entry['published_at']) ? formatDate($entry['published_at'], 'd.m.Y') : '';
  ?>
      <article class="log-entry">
        <span class="log-entry__ribbon">Entry &middot; <?= h($entryNum) ?></span>
        <div class="log-entry__header">
          <span class="log-entry__date"><?= h($pubDate) ?><?php if (!empty($entry['location'])): ?> &middot; <?= h($entry['location']) ?><?php endif; ?></span>
          <h3 class="log-entry__title"><?= $entry['title_html'] ?? h($entry['title']) ?></h3>
        </div>
        <p class="log-entry__body"><?= h($entry['excerpt'] ?? $entry['body'] ?? '') ?></p>
        <div class="log-entry__footer">
          <span class="log-entry__signature"><?= h(mb_substr($entry['author'] ?? 'K', 0, 1)) ?>.</span>
          <div class="log-entry__author"><strong><?= h($entry['author'] ?? 'Crew') ?></strong>gut salzig</div>
        </div>
      </article>
  <?php endforeach; ?>
<?php else: ?>
      <article class="log-entry">
        <span class="log-entry__ribbon">Entry &middot; 042</span>
        <div class="log-entry__header">
          <span class="log-entry__date">14.04.2026 &middot; Stein Harbour &middot; 54&deg;26'N</span>
          <h3 class="log-entry__title">Der erste <em>Dorsch</em> der Saison.</h3>
        </div>
        <p class="log-entry__body">Heute morgen kam Kutter M&ouml;we mit dem ersten fangfrischen Dorsch der Saison an den Steg. Wird heute Abend zum Tagesgericht &mdash; gebraten auf Salzkartoffel-Stampf mit jungem Spinat und Senfbeurre.</p>
        <div class="log-entry__footer">
          <span class="log-entry__signature">K.</span>
          <div class="log-entry__author"><strong>K&uuml;chencrew</strong>gut salzig</div>
        </div>
      </article>
      <article class="log-entry">
        <span class="log-entry__ribbon">Entry &middot; 041</span>
        <div class="log-entry__header">
          <span class="log-entry__date">11.04.2026 &middot; Wintergarten &middot; 10&deg;14'E</span>
          <h3 class="log-entry__title">Pampasgras in <em>voller</em> Pracht.</h3>
        </div>
        <p class="log-entry__body">Der Wintergarten hat neue Trockenblumen-Arrangements bekommen. Pampasgras, Hortensien und Sanddorn-Zweige &mdash; alles von lokalen Floristinnen. Perfektes Licht f&uuml;r die n&auml;chste Hochzeit.</p>
        <div class="log-entry__footer">
          <span class="log-entry__signature">L.</span>
          <div class="log-entry__author"><strong>Service-Crew</strong>gut salzig</div>
        </div>
      </article>
      <article class="log-entry">
        <span class="log-entry__ribbon">Entry &middot; 040</span>
        <div class="log-entry__header">
          <span class="log-entry__date">07.04.2026 &middot; Probstei &middot; Wind N 8 kn</span>
          <h3 class="log-entry__title">Neuer Winzer aus der <em>Pfalz</em>.</h3>
        </div>
        <p class="log-entry__body">Beim Weinabend am 28. Juni begr&uuml;&szlig;en wir Winzer Lenz aus der Pfalz. Sechs Weine, sechs G&auml;nge, jede Menge Geschichten. Tickets sind ab sofort verf&uuml;gbar &mdash; begrenzte Pl&auml;tze.</p>
        <div class="log-entry__footer">
          <span class="log-entry__signature">C.</span>
          <div class="log-entry__author"><strong>Captain</strong>gut salzig</div>
        </div>
      </article>
<?php endif; ?>
    </div>

    <div style="text-align:center; margin-top: 3.5rem;" class="reveal">
      <a href="#" class="btn btn--outline">Alle Log-Eintr&auml;ge <span class="arrow">&rarr;</span></a>
    </div>
  </div>
</section>

<!-- =========================================================
     TESTIMONIALS — 2x2 Foto-Grid + Zitat
     ========================================================= -->
<section class="testimonials">
  <div class="wrap">
    <div class="testimonials__grid">
      <div class="photo-quad reveal-stagger">
        <div class="photo-quad__item"><img src="prototype/assets/images/test-1.jpg" alt=""></div>
        <div class="photo-quad__item"><img src="prototype/assets/images/test-2.jpg" alt=""></div>
        <div class="photo-quad__item"><img src="prototype/assets/images/test-3.jpg" alt=""></div>
        <div class="photo-quad__item"><img src="prototype/assets/images/test-4.jpg" alt=""></div>
        <div class="travel-label" aria-hidden="true">
          <div class="travel-label__inner">
            <span class="travel-label__top">Guest &middot; Pick</span>
            <span class="travel-label__main">Ostsee</span>
            <span class="travel-label__stars">&#9733; &#9733; &#9733; &#9733; &#9733;</span>
            <span class="travel-label__bottom">Local Favourite</span>
          </div>
        </div>
      </div>
      <div class="testimonials__content reveal">
        <span class="eyebrow">Was G&auml;ste sagen</span>
        <h2>Stimmen aus<br>unserem <em>Gastraum</em>.</h2>
        <p class="testimonials__quote">&bdquo;Ein Ort, an dem die Zeit stehenbleibt. Der Brunch war traumhaft, die Atmosph&auml;re genau das, was man nach einer langen Woche braucht &mdash; wirklich wie ein Tag Urlaub am Meer.&ldquo;</p>
        <div class="testimonials__author">
          <span><strong>Julia K.</strong></span>
          <span class="testimonials__stars">&#9733;&#9733;&#9733;&#9733;&#9733;</span>
          <span>Google Bewertung</span>
        </div>
        <a href="#" class="link">Alle Bewertungen &rarr;</a>
      </div>
    </div>
  </div>
</section>

<!-- =========================================================
     FLIGHT VOUCHERS — Geschenkgutscheine
     ========================================================= -->
<section class="vouchers">
  <div class="wrap">
    <div class="section-head reveal">
      <h2>Flight<br><em>Vouchers</em>.</h2>
      <p>Geschenke, die sich wie ein kleiner Urlaub anf&uuml;hlen. Drei Kategorien, jeweils als digitaler Boarding Pass zum Ausdrucken oder direkt per Mail verschicken.</p>
    </div>

    <div class="vouchers__grid reveal-stagger">
      <article class="voucher">
        <div class="voucher__airline">
          <div class="voucher__brand"><span class="voucher__brand-icon">&#9992;</span><span class="voucher__brand-name">GUT SALZIG</span></div>
          <span class="voucher__label">Economy</span>
        </div>
        <div class="voucher__value-block">
          <span class="voucher__value-label">Boarding &middot; Single</span>
          <span class="voucher__value">50<sup>&euro;</sup></span>
        </div>
        <div class="voucher__body">Perfekt f&uuml;r einen Sonntagsbrunch zu zweit oder ein gem&uuml;tliches Abendessen &agrave; la carte.</div>
        <div class="voucher__meta">
          <div class="voucher__meta-item"><span class="voucher__meta-label">Class</span><span class="voucher__meta-value">ECO</span></div>
          <div class="voucher__meta-item"><span class="voucher__meta-label">Valid</span><span class="voucher__meta-value">24 Mo</span></div>
          <div class="voucher__meta-item"><span class="voucher__meta-label">Code</span><span class="voucher__meta-value">GS&middot;50</span></div>
        </div>
        <button type="button" class="voucher__buy">Gutschein kaufen <span class="arrow">&rarr;</span></button>
        <div class="voucher__code">PNR &middot; Wird bei Kauf generiert</div>
      </article>

      <article class="voucher voucher--featured">
        <div class="voucher__airline">
          <div class="voucher__brand"><span class="voucher__brand-icon">&#9992;</span><span class="voucher__brand-name">GUT SALZIG</span></div>
          <span class="voucher__label">Business</span>
        </div>
        <div class="voucher__value-block">
          <span class="voucher__value-label">Boarding &middot; Couple</span>
          <span class="voucher__value">100<sup>&euro;</sup></span>
        </div>
        <div class="voucher__body">Unser Bestseller: ein kompletter Sonntag mit Brunch, Kaffee-Pause und Abendessen f&uuml;r zwei.</div>
        <div class="voucher__meta">
          <div class="voucher__meta-item"><span class="voucher__meta-label">Class</span><span class="voucher__meta-value">BUS</span></div>
          <div class="voucher__meta-item"><span class="voucher__meta-label">Valid</span><span class="voucher__meta-value">24 Mo</span></div>
          <div class="voucher__meta-item"><span class="voucher__meta-label">Code</span><span class="voucher__meta-value">GS&middot;100</span></div>
        </div>
        <button type="button" class="voucher__buy">Gutschein kaufen <span class="arrow">&rarr;</span></button>
        <div class="voucher__code">PNR &middot; Wird bei Kauf generiert</div>
      </article>

      <article class="voucher">
        <div class="voucher__airline">
          <div class="voucher__brand"><span class="voucher__brand-icon">&#9992;</span><span class="voucher__brand-name">GUT SALZIG</span></div>
          <span class="voucher__label">First</span>
        </div>
        <div class="voucher__value-block">
          <span class="voucher__value-label">Boarding &middot; Event</span>
          <span class="voucher__value">150<sup>&euro;</sup></span>
        </div>
        <div class="voucher__body">F&uuml;r einen ganzen Abend mit Weinabend, Feiertag-Men&uuml; oder einem Event aus unserer Abflugtafel.</div>
        <div class="voucher__meta">
          <div class="voucher__meta-item"><span class="voucher__meta-label">Class</span><span class="voucher__meta-value">FST</span></div>
          <div class="voucher__meta-item"><span class="voucher__meta-label">Valid</span><span class="voucher__meta-value">24 Mo</span></div>
          <div class="voucher__meta-item"><span class="voucher__meta-label">Code</span><span class="voucher__meta-value">GS&middot;150</span></div>
        </div>
        <button type="button" class="voucher__buy">Gutschein kaufen <span class="arrow">&rarr;</span></button>
        <div class="voucher__code">PNR &middot; Wird bei Kauf generiert</div>
      </article>
    </div>
  </div>
</section>

<!-- =========================================================
     NEWSLETTER — Newsletter Boarding Pass mit Topics
     ========================================================= -->
<section class="announcement">
  <div class="wrap">
    <div class="section-head reveal">
      <h2>Abonniere unser<br><em>Logbuch</em>.</h2>
      <p>Einmal im Monat eine Durchsage in dein Postfach. W&auml;hle deine Destinations und lande genau bei den News, die dich interessieren.</p>
    </div>

    <form class="newsletter-pass reveal" onsubmit="event.preventDefault(); alert('Demo — Newsletter wird im Prototyp nicht wirklich abonniert.');">

      <!-- LEFT: Photo Panel -->
      <div class="newsletter-pass__photo">
        <img src="prototype/assets/images/intro-gastraum.jpg" alt="">
        <div class="newsletter-pass__photo-overlay">
          <div class="newsletter-pass__photo-top">
            <span class="newsletter-pass__photo-badge">Live Boarding</span>
            <span class="newsletter-pass__photo-issue">Issue<br>042 &middot; 2026</span>
          </div>
          <div class="newsletter-pass__photo-bottom">
            <span class="newsletter-pass__photo-eyebrow">Newsletter &middot; Inflight Magazine</span>
            <h3 class="newsletter-pass__photo-title">Captain's<br><em>Logbuch</em></h3>
            <dl class="newsletter-pass__photo-meta">
              <div><dt>Frequency</dt><dd>1&times; Monat</dd></div>
              <div><dt>Cancel</dt><dd>Jederzeit</dd></div>
              <div><dt>Class</dt><dd>NL &middot; Pass</dd></div>
              <div><dt>Carrier</dt><dd>GS &middot; STN</dd></div>
            </dl>
          </div>
        </div>
      </div>

      <!-- RIGHT: Boarding Pass Body -->
      <div class="newsletter-pass__main">
        <div class="newsletter-pass__header">
          <div class="newsletter-pass__brand">
            <span class="newsletter-pass__brand-icon">&#9992;</span>
            <span class="newsletter-pass__brand-name">GUT SALZIG</span>
          </div>
          <span class="newsletter-pass__class">Newsletter &middot; Boarding Pass</span>
        </div>

        <div class="newsletter-pass__route">
          <div class="newsletter-pass__route-item">
            <span class="newsletter-pass__route-label">From</span>
            <span class="newsletter-pass__iata">STN</span>
            <span class="newsletter-pass__city">Stein &middot; F&ouml;rde</span>
          </div>
          <div class="newsletter-pass__arc">
            <svg viewBox="0 0 120 36" preserveAspectRatio="none">
              <path d="M 4 26 Q 60 -6 116 26"/>
              <text x="56" y="12">&#9992;</text>
            </svg>
          </div>
          <div class="newsletter-pass__route-item newsletter-pass__route-item--to">
            <span class="newsletter-pass__route-label">To</span>
            <span class="newsletter-pass__iata">INBOX</span>
            <span class="newsletter-pass__city">Dein Postfach</span>
          </div>
        </div>

        <div class="newsletter-pass__boarding">
          <div class="newsletter-pass__boarding-item">
            <span class="newsletter-pass__boarding-label">Flight</span>
            <span class="newsletter-pass__boarding-value newsletter-pass__boarding-value--accent">NL &middot; 042</span>
          </div>
          <div class="newsletter-pass__boarding-item">
            <span class="newsletter-pass__boarding-label">Date</span>
            <span class="newsletter-pass__boarding-value">Heute</span>
          </div>
          <div class="newsletter-pass__boarding-item">
            <span class="newsletter-pass__boarding-label">Group</span>
            <span class="newsletter-pass__boarding-value">A</span>
          </div>
          <div class="newsletter-pass__boarding-item">
            <span class="newsletter-pass__boarding-label">Seat</span>
            <span class="newsletter-pass__boarding-value">12 F</span>
          </div>
        </div>

        <div class="newsletter-pass__body">
          <div class="newsletter-pass__row">
            <div class="newsletter-pass__field">
              <label for="nl-name">Passenger Name</label>
              <input id="nl-name" type="text" placeholder="Dein Name" required>
            </div>
            <div class="newsletter-pass__field">
              <label for="nl-email">Boarding Address</label>
              <input id="nl-email" type="email" placeholder="du@beispiel.de" required>
            </div>
          </div>

          <span class="newsletter-pass__topics-label">W&auml;hle deine Destinations</span>
          <div class="newsletter-pass__topics">
            <label class="topic">
              <input type="checkbox" name="topics" value="brunch" checked>
              <span class="topic__check"></span>
              <span class="topic__label">
                <span class="topic__title">Brunch &amp; Fr&uuml;hst&uuml;ck</span>
                <span class="topic__desc">Wochenmen&uuml; Sa &amp; So</span>
              </span>
            </label>

            <label class="topic">
              <input type="checkbox" name="topics" value="events" checked>
              <span class="topic__check"></span>
              <span class="topic__label">
                <span class="topic__title">Events &amp; Live-Musik</span>
                <span class="topic__desc">Konzerte &middot; Workshops &middot; Lesungen</span>
              </span>
            </label>

            <label class="topic">
              <input type="checkbox" name="topics" value="kueche">
              <span class="topic__check"></span>
              <span class="topic__label">
                <span class="topic__title">Aus der K&uuml;che</span>
                <span class="topic__desc">Tagesgerichte &middot; Saisonales</span>
              </span>
            </label>

            <label class="topic">
              <input type="checkbox" name="topics" value="feiern">
              <span class="topic__check"></span>
              <span class="topic__label">
                <span class="topic__title">Hochzeiten &amp; Feiern</span>
                <span class="topic__desc">Location &middot; Pakete &middot; Inspiration</span>
              </span>
            </label>

            <label class="topic">
              <input type="checkbox" name="topics" value="log">
              <span class="topic__check"></span>
              <span class="topic__label">
                <span class="topic__title">Captain's Log</span>
                <span class="topic__desc">Geschichten aus dem Restaurant</span>
              </span>
            </label>

            <label class="topic">
              <input type="checkbox" name="topics" value="aktionen">
              <span class="topic__check"></span>
              <span class="topic__label">
                <span class="topic__title">Spezialangebote</span>
                <span class="topic__desc">Aktionen &middot; Frequent Flyer</span>
              </span>
            </label>
          </div>

          <div class="newsletter-pass__footer">
            <span class="newsletter-pass__pnr">PNR<strong>NL&middot;GS&middot;042</strong><br>1&times; Monat &middot; Jederzeit abmeldbar</span>
            <div class="newsletter-pass__barcode" aria-hidden="true"></div>
            <button type="submit" class="newsletter-pass__submit">Boarding Pass abholen <span class="arrow">&rarr;</span></button>
          </div>
        </div>
      </div>
    </form>
  </div>
</section>

<!-- =========================================================
     KONTAKT — Photo-Pair Layout
     ========================================================= -->
<section class="contact" id="kontakt">
  <div class="wrap">
    <div class="contact__grid">
      <div class="photo-pair reveal">
        <div class="photo-pair__item"><img src="prototype/assets/images/visit-1.jpg" alt="Brunch-Moment"></div>
        <div class="photo-pair__item"><img src="prototype/assets/images/visit-2.jpg" alt="Gedeckter Tisch"></div>
      </div>

      <div class="reveal">
        <span class="eyebrow">Reservierung</span>
        <h2>Besuch uns<br>am <em>Meer</em>.</h2>
        <p>Reserviere deinen Tisch f&uuml;r Brunch, Abendessen oder eine Feier. Wir freuen uns auf dich.</p>

        <div class="contact__info">
          <div>
            <strong>Adresse</strong>
            <span>Uferkoppel 10<br>24235 Stein</span>
          </div>
          <div>
            <strong>Telefon</strong>
            <span>04343 1859155</span>
          </div>
        </div>

        <a href="kontakt.php" class="link" style="margin-top:2rem;">Route planen &rarr;</a>
      </div>
    </div>

    <form class="postcard reveal" action="kontakt.php" method="post">
      <?= csrfField() ?>
      <div class="postcard__header">
        <span class="postcard__greetings">Greetings from <em>Stein</em>,</span>
        <span><strong>POST &middot; GUT SALZIG</strong> &middot; Airmail &middot; Par Avion</span>
      </div>

      <div class="postcard__left">
        <label class="postcard__label" for="pc-msg">Deine Nachricht</label>
        <textarea id="pc-msg" name="message" class="postcard__message" placeholder="Hallo gut salzig, ich w&uuml;rde gerne&hellip;"></textarea>
        <div class="postcard__from">
          <label for="pc-from">Von:</label>
          <input id="pc-from" name="from_display" type="text" placeholder="Dein Name">
        </div>
        <div class="postcard__visa" aria-hidden="true">
          <span class="postcard__visa-top">Entry Visa</span>
          <span class="postcard__visa-main">Cleared</span>
          <span class="postcard__visa-bottom">GS &middot; Stein 2026</span>
        </div>
      </div>

      <div class="postcard__right">
        <div class="postcard__stamp-row">
          <div class="postcard__stamp">
            <div class="postcard__stamp-inner">
              <img src="prototype/assets/logo/icon-blk.svg" alt="">
              <div class="postcard__stamp-value">GS &middot; 0,95</div>
              <div class="postcard__stamp-region">Ostsee &middot; DE</div>
            </div>
          </div>
          <div class="postcard__postmark">
            <div class="postcard__postmark-city">Stein</div>
            <div class="postcard__postmark-date">Heute</div>
            <div class="postcard__postmark-country">54&deg;26'N &middot; Ostsee</div>
          </div>
        </div>

        <div class="postcard__to">
          <span class="postcard__to-label">An gut salzig &mdash; Absender</span>
          <div class="postcard__to-field">
            <label for="pc-name">Name</label>
            <input id="pc-name" name="name" type="text" placeholder="Max Mustermann" required>
          </div>
          <div class="postcard__to-field">
            <label for="pc-email">Mail</label>
            <input id="pc-email" name="email" type="email" placeholder="du@beispiel.de" required>
          </div>
          <div class="postcard__to-field">
            <label for="pc-tel">Tel</label>
            <input id="pc-tel" name="phone" type="tel" placeholder="04343 &hellip;">
          </div>
          <div class="postcard__to-field">
            <label for="pc-anlass">Anlass</label>
            <select id="pc-anlass" name="subject">
              <option>Tischreservierung</option>
              <option>Sonntagsbrunch</option>
              <option>Samstags-Fr&uuml;hst&uuml;ck</option>
              <option>Event-Anfrage</option>
              <option>Hochzeit</option>
              <option>Firmenfeier</option>
              <option>Weihnachtsfeier</option>
              <option>Junggesellinnenabschied</option>
              <option>Andere Feier</option>
            </select>
          </div>
          <div class="postcard__to-field">
            <label for="pc-date">Datum</label>
            <input id="pc-date" name="date" type="date">
          </div>
        </div>

        <button type="submit" class="postcard__send">Postkarte abschicken <span class="arrow">&#9992;</span></button>
      </div>
    </form>
    </div>
  </div>
</section>

<!-- =========================================================
     FOOTER
     ========================================================= -->
<footer class="footer">
  <div class="wrap-wide">
    <div class="footer__main">

      <div class="footer__col footer__col--brand">
        <a href="#top" class="footer__brand">
          <img src="prototype/assets/logo/logo2-wht.svg" alt="gut salzig">
        </a>
        <p class="footer__tagline">&hellip;wie ein Tag Urlaub am Meer.</p>
        <div class="footer__social">
          <a href="#" aria-label="Instagram">Ig</a>
          <a href="#" aria-label="Facebook">Fb</a>
          <a href="#" aria-label="Google Reviews">Go</a>
        </div>
      </div>

      <div class="footer__col">
        <h4 class="footer__heading">Erkunden</h4>
        <nav class="footer__nav-list">
          <a href="#angebot">Angebot</a>
          <a href="kueche.php">K&uuml;che</a>
          <a href="brunch.php">Sonntagsbrunch</a>
          <a href="events.php">Events</a>
          <a href="feiern.php">Hochzeiten &amp; Feiern</a>
          <a href="galerie.php">Galerie</a>
          <a href="kontakt.php">Kontakt</a>
        </nav>
      </div>

      <div class="footer__col">
        <h4 class="footer__heading">Besuch uns</h4>
        <address class="footer__address">
          Uferkoppel 10<br>
          24235 Stein<br>
          an der Kieler F&ouml;rde
        </address>
        <a href="tel:043431859155" class="footer__contact">04343 1859155</a>
        <a href="mailto:flaschenpost@gut-salzig.de" class="footer__contact">flaschenpost@gut-salzig.de</a>
      </div>

      <div class="footer__col">
        <h4 class="footer__heading">Flight Schedule</h4>
        <div class="flight-schedule">
          <div class="flight-schedule__row">
            <span class="flight-schedule__day">Mo&ndash;Mi</span>
            <span>Ruhetag</span>
            <span class="flight-schedule__status flight-schedule__status--closed">Closed</span>
          </div>
          <div class="flight-schedule__row">
            <span class="flight-schedule__day">Do &middot; Fr</span>
            <span>17 &ndash; 20</span>
            <span class="flight-schedule__status flight-schedule__status--ontime">On&nbsp;Time</span>
          </div>
          <div class="flight-schedule__row">
            <span class="flight-schedule__day">Samstag</span>
            <span>09 &ndash; 20</span>
            <span class="flight-schedule__status flight-schedule__status--ontime">On&nbsp;Time</span>
          </div>
          <div class="flight-schedule__row">
            <span class="flight-schedule__day">Sonntag</span>
            <span>10 &ndash; 20</span>
            <span class="flight-schedule__status flight-schedule__status--boarding">Boarding</span>
          </div>
        </div>
      </div>

    </div>

    <div class="footer__bottom">
      <span>&copy; 2026 gut salzig Beach Club &amp; Restaurant</span>
      <span class="footer__bottom-mark">
        <img src="prototype/assets/logo/icon-wht.svg" alt="" aria-hidden="true">
        <span>gut salzig &middot; Stein &middot; Ostsee</span>
      </span>
      <div class="footer__legal">
        <a href="impressum.php">Impressum</a>
        <a href="datenschutz.php">Datenschutz</a>
      </div>
    </div>
  </div>
</footer>

<!-- =========================================================
     BOARDING SOUND TOGGLE
     ========================================================= -->
<button class="sound-toggle" id="soundToggle" aria-label="Boarding-Sound abspielen">
  <span class="sound-toggle__ring" aria-hidden="true"></span>
  <svg viewBox="0 0 24 24"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02zM14 3.23v2.06c2.89.86 5 3.54 5 6.71s-2.11 5.85-5 6.71v2.06c4.01-.91 7-4.49 7-8.77s-2.99-7.86-7-8.77z"/></svg>
</button>

<!-- =========================================================
     COCKPIT WEATHER WIDGET
     ========================================================= -->
<aside class="cockpit" id="cockpit" aria-label="Wetter an der Kieler F&ouml;rde">
  <span class="cockpit__dot"></span>
  <div class="cockpit__label">Cockpit<br>F&ouml;rde</div>
  <div class="cockpit__divider"></div>
  <div class="cockpit__data">
    <span class="cockpit__temp" id="cockpitTemp">19&deg;</span>
    <span class="cockpit__meta" id="cockpitMeta">Sonne &middot; Wind 12 kn</span>
  </div>
  <button class="cockpit__close" id="cockpitClose" aria-label="Cockpit-Widget schlie&szlig;en">&times;</button>
</aside>

<script src="prototype/assets/js/main.js"></script>
</body>
</html>
