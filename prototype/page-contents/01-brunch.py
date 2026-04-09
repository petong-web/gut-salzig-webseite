build(
    slug="brunch",
    title="Brunch & Frühstück — gut salzig · Stein an der Ostsee",
    description="Samstags gemütliches Frühstück à la carte, sonntags großer Brunch mit wöchentlich wechselndem Menü direkt an der Kieler Förde.",
    content='''
<!-- HERO -->
<section class="subpage-hero">
  <div class="subpage-hero__media">
    <img src="assets/images/tile-brunch.jpg" alt="Brunch-Buffet bei gut salzig">
  </div>
  <div class="subpage-hero__content">
    <nav class="subpage-hero__breadcrumb">
      <a href="index.html">Home</a>
      <span class="sep">/</span>
      <span class="current">Brunch & Frühstück</span>
    </nav>
    <span class="subpage-hero__eyebrow">Samstag & Sonntag</span>
    <h1 class="subpage-hero__title">Das schönste Frühstück<br>der <em>Woche</em>.</h1>
    <p class="subpage-hero__sub">Samstags gemütliches Frühstück à la carte. Sonntags unser großer Brunch mit wöchentlich wechselndem Menü, frisch gebackenem Brot, Fisch, Käse und vielen Kleinigkeiten zum Probieren.</p>
  </div>
  <div class="subpage-hero__bar">
    <span>54°26′N · 10°14′E · Stein</span>
    <span class="subpage-hero__bar-flight">GS · BRUNCH · 042</span>
    <span>Reservierung empfohlen</span>
  </div>
</section>

<!-- Zwei Angebote nebeneinander -->
<section class="subpage-section">
  <div class="wrap">
    <div class="page-head reveal">
      <span class="eyebrow">Zwei Angebote</span>
      <h2>Wochenende beginnt <em>am Tisch</em>.</h2>
      <p>Wir haben das Wochenende in zwei Geschwindigkeiten aufgeteilt — einen ruhigen Samstag-Morgen und einen ausgiebigen Sonntags-Brunch. Beides lässt sich zur Reservierung anmelden.</p>
    </div>

    <div class="brunch__days" style="max-width: 900px; margin: 0 auto 4rem; grid-template-columns: 1fr 1fr; gap: 1.4rem;">
      <div class="brunch__day">
        <div class="brunch__day-label">Samstag</div>
        <div class="brunch__day-title">Frühstück<br>à la carte</div>
        <div class="brunch__day-meta">Ab 09:00 Uhr · aus der Karte bestellen<br>von klassisch bis ausgefallen</div>
      </div>
      <div class="brunch__day brunch__day--highlight">
        <div class="brunch__day-label">Sonntag</div>
        <div class="brunch__day-title">Brunch-<br>Buffet</div>
        <div class="brunch__day-meta">10 – 14 Uhr · 29 € p. P.<br>wöchentlich neues Menü</div>
      </div>
    </div>
  </div>
</section>

<!-- Brunch-Wochenmenü (dynamisch) -->
<section class="brunch" id="brunch">
  <div class="wrap">
    <div class="brunch__grid">
      <div class="brunch__content reveal">
        <span class="eyebrow">Sonntag, 19. April 2026</span>
        <h2>Diese Woche auf<br>dem <em>Tisch</em>.</h2>
        <p>Jeden Sonntag kuratieren wir ein neues Brunch-Menü. Frisch gebackenes Brot aus der eigenen Küche, Fisch vom heimischen Kutter, regionale Käse, Süßes und Herzhaftes — alles zum ausgiebigen Probieren.</p>

        <span class="brunch__menu-label">Unser Brunch-Menü</span>
        <ul class="brunch__menu">
          <li data-n="01">Hausgeräucherter Lachs mit Dill &amp; Roggen-Sauerteig</li>
          <li data-n="02">Pochierte Eier auf jungem Spinat, Sauce Hollandaise</li>
          <li data-n="03">Nordsee-Krabben auf Rührei mit Schnittlauch</li>
          <li data-n="04">Granola mit Ostsee-Honig &amp; frischen Beeren</li>
          <li data-n="05">Regionale Käse-Auswahl &amp; warme Buchteln</li>
          <li data-n="06">Ofenkartoffeln mit Sauerrahm &amp; Kräutern</li>
          <li data-n="07">Obstteller der Saison · süße Aufstriche</li>
          <li data-n="08">Kaffee, Tee &amp; hausgemachte Limonade inklusive</li>
        </ul>

        <a href="kontakt.html" class="btn btn--primary">Platz reservieren <span class="arrow">→</span></a>
      </div>
      <div class="brunch__image reveal">
        <span class="brunch__badge">Live · jeden Sonntag neu</span>
        <img src="assets/images/brunch-vertical.jpg" alt="Sonntagsbrunch bei gut salzig">
      </div>
    </div>
  </div>
</section>

<!-- Samstag Frühstück Karte -->
<section class="subpage-section subpage-section--cream">
  <div class="wrap">
    <div class="page-head reveal">
      <span class="eyebrow">Samstag</span>
      <h2>Frühstück <em>à la carte</em>.</h2>
      <p>Gemütlicher Start ins Wochenende. Entspannte Atmosphäre, langsames Tempo — für alle, die den Tisch lieber für sich haben statt sich am Buffet einzureihen.</p>
    </div>

    <div class="celebrations__grid reveal-stagger" style="max-width: 1100px; margin-inline: auto;">
      <article class="celebration">
        <img src="assets/images/dish-3.jpg" alt="Klassisches Frühstück">
        <div class="luggage-tag" aria-hidden="true">
          <span class="luggage-tag__number">No. 01</span>
          <span class="luggage-tag__label">Klassisch</span>
          <span class="luggage-tag__code">GS · BFK</span>
        </div>
        <div class="celebration__body">
          <h3>Gut Salzig <em>Klassik</em></h3>
          <p>Brot · Käse · Schinken · Ei — 14 €</p>
        </div>
      </article>
      <article class="celebration">
        <img src="assets/images/intro-food.jpg" alt="Früchte-Frühstück">
        <div class="luggage-tag" aria-hidden="true">
          <span class="luggage-tag__number">No. 02</span>
          <span class="luggage-tag__label">Vital</span>
          <span class="luggage-tag__code">GS · VIT</span>
        </div>
        <div class="celebration__body">
          <h3>Vital-<em>Frühstück</em></h3>
          <p>Joghurt · Granola · Obst · Honig — 12 €</p>
        </div>
      </article>
      <article class="celebration">
        <img src="assets/images/dish-2.jpg" alt="Deluxe Frühstück">
        <div class="luggage-tag" aria-hidden="true">
          <span class="luggage-tag__number">No. 03</span>
          <span class="luggage-tag__label">Deluxe</span>
          <span class="luggage-tag__code">GS · LUX</span>
        </div>
        <div class="celebration__body">
          <h3>Ostsee <em>Deluxe</em></h3>
          <p>Lachs · Krabben · Avocado · Rührei — 22 €</p>
        </div>
      </article>
    </div>
  </div>
</section>

<!-- FAQ -->
<section class="subpage-section">
  <div class="wrap">
    <div class="page-head reveal">
      <span class="eyebrow">Gut zu wissen</span>
      <h2>Häufige <em>Fragen</em>.</h2>
    </div>

    <div class="captains-log__grid reveal-stagger" style="max-width: 1100px; margin-inline: auto;">
      <article class="log-entry">
        <span class="log-entry__ribbon">FAQ · 01</span>
        <div class="log-entry__header">
          <h3 class="log-entry__title">Muss ich <em>reservieren</em>?</h3>
        </div>
        <p class="log-entry__body">Ja, wir empfehlen unbedingt eine Reservierung — besonders für den Sonntagsbrunch. Die Plätze sind schnell vergeben, vor allem in der Saison.</p>
      </article>
      <article class="log-entry">
        <span class="log-entry__ribbon">FAQ · 02</span>
        <div class="log-entry__header">
          <h3 class="log-entry__title">Wie lange darf ich <em>bleiben</em>?</h3>
        </div>
        <p class="log-entry__body">So lange du magst! Beim Brunch planen wir ca. 2 Stunden pro Tisch ein, aber wenn es nicht voll ist, freuen wir uns über jede Minute mehr.</p>
      </article>
      <article class="log-entry">
        <span class="log-entry__ribbon">FAQ · 03</span>
        <div class="log-entry__header">
          <h3 class="log-entry__title">Sind <em>Kinder</em> willkommen?</h3>
        </div>
        <p class="log-entry__body">Absolut. Wir haben Hochstühle, kindgerechte Portionen und im Sommer Sandkasten &amp; Spielzeug am Strand. Kinder bis 6 Jahre brunchen gratis.</p>
      </article>
    </div>
  </div>
</section>
'''
)
