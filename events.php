<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/functions.php';
session_start();

$title = "Events & Veranstaltungen — gut salzig · Boarding Pass zu jedem Event";
$description = "Alle Events bei gut salzig: Weinabende, Live-Musik, Workshops, Buffets und Feiertags-Specials. Als digitaler Boarding Pass buchbar.";

// Pull all active future events
$events = dbQuery(
    "SELECT * FROM events WHERE is_active = 1 AND event_date >= CURDATE() ORDER BY event_date",
    []
);
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
    <img src="prototype/assets/images/event-1.jpg" alt="Events bei gut salzig">
  </div>
  <div class="subpage-hero__content">
    <nav class="subpage-hero__breadcrumb">
      <a href="index.php">Home</a>
      <span class="sep">/</span>
      <span class="current">Events</span>
    </nav>
    <span class="subpage-hero__eyebrow">Abflugtafel</span>
    <h1 class="subpage-hero__title">Alle Flights<br>zum <em>Wochenende</em>.</h1>
    <p class="subpage-hero__sub">Unsere komplette Abflugtafel. Filter nach Monat und Kategorie, buche als Boarding Pass oder reserviere direkt. Manche Events sind frei, bei anderen gibt es Tickets oder Reservierung.</p>
  </div>
  <div class="subpage-hero__bar">
    <span>54&deg;26&prime;N &middot; 10&deg;14&prime;E &middot; Stein</span>
    <span class="subpage-hero__bar-flight">GS &middot; EVENTS &middot; LIVE</span>
    <span id="gsClock">&mdash;&mdash; :&mdash;&mdash;</span>
  </div>
</section>

<!-- Events Board -->
<section class="events" style="background: var(--bg);">
  <div class="wrap">

    <div class="departure-board reveal">
      <div class="departure-board__label"><span class="departure-board__dot"></span>LIVE &middot; GUT SALZIG DEPARTURES</div>
      <div class="departure-board__marquee">NEXT DESTINATIONS &middot; STEIN &rarr; ENTSCHLEUNIGUNG</div>
      <div class="departure-board__clock"><?= count($events) ?> Flights gelistet</div>
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
<?php
$months = [];
foreach ($events as $ev) {
    $m = date('F Y', strtotime($ev['event_date']));
    if (!in_array($m, $months)) $months[] = $m;
}
foreach ($months as $m): ?>
          <option><?= h($m) ?></option>
<?php endforeach; ?>
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
<?php if (empty($events)): ?>
      <p style="text-align:center; color: var(--ink-soft); font-style:italic; padding: 3rem 0;">Aktuell sind keine kommenden Events geplant. Schau bald wieder vorbei!</p>
<?php else: ?>
  <?php foreach ($events as $ev):
    $pnr = generatePNR($ev['event_date']);
    $dateFormatted = strtoupper(date('d M y', strtotime($ev['event_date'])));
    $timeFormatted = !empty($ev['event_time']) ? formatTime($ev['event_time']) : '';
    $iataCode = strtoupper(substr($ev['slug'] ?? slugify($ev['title']), 0, 3));

    // Determine status class and label
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
            </div>
            <a href="kontakt.php" class="ticket__book"><?= $bookLabel ?> <span class="arrow">&rarr;</span></a>
          </div>
        </div>
      </article>
  <?php endforeach; ?>
<?php endif; ?>

    </div>
  </div>
</section>

<!-- Archive Call-out -->
<section class="subpage-section subpage-section--cream">
  <div class="wrap" style="text-align: center;">
    <div class="page-head reveal">
      <span class="eyebrow">Vergangene Flights</span>
      <h2>Das <em>Logbuch</em>.</h2>
      <p>Alle vergangenen Events findest du in unserem Event-Archiv &mdash; mit Fotos, Stimmungen und kleinen Erinnerungen an besondere Abende.</p>
    </div>
    <a href="#" class="btn btn--outline">Zum Archiv <span class="arrow">&rarr;</span></a>
  </div>
</section>


<?php require 'includes/footer.php'; ?>
</body>
</html>
