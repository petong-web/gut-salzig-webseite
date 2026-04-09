build(
    slug="events",
    title="Events & Veranstaltungen — gut salzig · Boarding Pass zu jedem Event",
    description="Alle Events bei gut salzig: Weinabende, Live-Musik, Workshops, Buffets und Feiertags-Specials. Als digitaler Boarding Pass buchbar.",
    content='''
<!-- HERO -->
<section class="subpage-hero">
  <div class="subpage-hero__media">
    <img src="assets/images/event-1.jpg" alt="Events bei gut salzig">
  </div>
  <div class="subpage-hero__content">
    <nav class="subpage-hero__breadcrumb">
      <a href="index.html">Home</a>
      <span class="sep">/</span>
      <span class="current">Events</span>
    </nav>
    <span class="subpage-hero__eyebrow">Abflugtafel</span>
    <h1 class="subpage-hero__title">Alle Flights<br>zum <em>Wochenende</em>.</h1>
    <p class="subpage-hero__sub">Unsere komplette Abflugtafel. Filter nach Monat und Kategorie, buche als Boarding Pass oder reserviere direkt. Manche Events sind frei, bei anderen gibt es Tickets oder Reservierung.</p>
  </div>
  <div class="subpage-hero__bar">
    <span>54°26′N · 10°14′E · Stein</span>
    <span class="subpage-hero__bar-flight">GS · EVENTS · LIVE</span>
    <span id="gsClock">—— :——</span>
  </div>
</section>

<!-- Events Board -->
<section class="events" style="background: var(--bg);">
  <div class="wrap">

    <div class="departure-board reveal">
      <div class="departure-board__label"><span class="departure-board__dot"></span>LIVE · GUT SALZIG DEPARTURES</div>
      <div class="departure-board__marquee">NEXT DESTINATIONS · STEIN → ENTSCHLEUNIGUNG</div>
      <div class="departure-board__clock">6 Flights gelistet</div>
    </div>

    <form class="flight-search reveal" onsubmit="event.preventDefault();">
      <div class="flight-search__field">
        <label class="flight-search__label">Departure</label>
        <div class="flight-search__value flight-search__value--static">Stein · STN</div>
      </div>
      <div class="flight-search__arrow">✈</div>
      <div class="flight-search__field">
        <label class="flight-search__label">Destination</label>
        <select class="flight-search__value">
          <option>Alle Events</option>
          <option>Sommerfest</option>
          <option>Weinabend</option>
          <option>Beach-Yoga</option>
          <option>Fischmarkt</option>
          <option>Candle Light Dinner</option>
          <option>Herbstbrunch</option>
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
      <button type="submit" class="flight-search__submit">Suchen <span class="arrow">→</span></button>
    </form>

    <div class="tickets reveal-stagger">

      ''' + ''.join([f'''
      <article class="ticket">
        <div class="ticket__photo">
          <img src="assets/images/event-{(i%4)+1}.jpg" alt="{title}">
          <div class="ticket__tags">
            <span class="ticket__status ticket__status--{status}">{status_label}</span>
            <span class="ticket__category"><span class="ticket__category-icon">{icon}</span>{category}</span>
          </div>
        </div>
        <div class="ticket__body">
          <div class="ticket__airline">
            <div class="ticket__brand"><span class="ticket__brand-icon">✈</span><span class="ticket__brand-name">GUT SALZIG</span></div>
            <small>Boarding Pass</small>
          </div>
          <div class="ticket__route">
            <div class="ticket__route-item">
              <span class="ticket__iata">STN</span>
              <span class="ticket__city">Stein · Förde</span>
            </div>
            <div class="ticket__arc">
              <svg viewBox="0 0 80 28" preserveAspectRatio="none">
                <path d="M 2 22 Q 40 -4 78 22"/>
                <text x="37" y="10">✈</text>
              </svg>
            </div>
            <div class="ticket__route-item ticket__route-item--to">
              <span class="ticket__iata">{iata}</span>
              <span class="ticket__city">{title}</span>
            </div>
          </div>
          <div class="ticket__meta">
            <div class="ticket__meta-item"><span class="ticket__meta-label">Date</span><span class="ticket__meta-value">{date}</span></div>
            <div class="ticket__meta-item"><span class="ticket__meta-label">Depart</span><span class="ticket__meta-value">{time}</span></div>
            <div class="ticket__meta-item"><span class="ticket__meta-label">{meta3_label}</span><span class="ticket__meta-value">{meta3_value}</span></div>
            <div class="ticket__meta-item"><span class="ticket__meta-label">Class</span><span class="ticket__meta-value ticket__meta-value--accent">{cls}</span></div>
          </div>
          <div class="ticket__footer">
            <div class="ticket__footer-left">
              <span class="ticket__pnr">PNR <strong>{pnr}</strong></span>
            </div>
            <a href="kontakt.html" class="ticket__book">{cta} <span class="arrow">→</span></a>
          </div>
        </div>
      </article>
      ''' for i, (title, iata, date, time, meta3_label, meta3_value, cls, status, status_label, category, icon, pnr, cta) in enumerate([
        ("Sommerfest", "SOM", "14 JUN 26", "18:00", "Gate", "Terr.", "Free", "info", "Free", "Live Musik", "♪", "GS140626", "Anmelden"),
        ("Weinabend", "WIN", "28 JUN 26", "19:30", "Menu", "6 Gang", "89 €", "ticket", "Ticket", "Buffet", "◉", "GS280626", "Buchen"),
        ("Beach-Yoga", "YOG", "12 JUL 26", "09:00", "Mit", "Lotta", "Brunch", "reserve", "Reserve", "Workshop", "✎", "GS120726", "Reservieren"),
        ("Fischmarkt", "FIS", "03 AUG 26", "11:00", "Dauer", "Ganztags", "Free", "info", "Free", "Feiertag", "★", "GS030826", "Mehr Infos"),
        ("Candle Light", "CDL", "14 FEB 26", "19:00", "Menu", "5 Gang", "75 €", "ticket", "Ticket", "Live Musik", "♪", "GS140226", "Buchen"),
        ("Herbstbrunch", "HBS", "26 OKT 26", "10:00", "Dauer", "4 Std", "32 €", "ticket", "Ticket", "Buffet", "◉", "GS261026", "Buchen"),
      ])]) + '''
    </div>
  </div>
</section>

<!-- Archive Call-out -->
<section class="subpage-section subpage-section--cream">
  <div class="wrap" style="text-align: center;">
    <div class="page-head reveal">
      <span class="eyebrow">Vergangene Flights</span>
      <h2>Das <em>Logbuch</em>.</h2>
      <p>Alle vergangenen Events findest du in unserem Event-Archiv — mit Fotos, Stimmungen und kleinen Erinnerungen an besondere Abende.</p>
    </div>
    <a href="#" class="btn btn--outline">Zum Archiv <span class="arrow">→</span></a>
  </div>
</section>
'''
)
