build(
    slug="kueche",
    title="Küche & Speisekarte — gut salzig · Kreative deutsche Küche mit Fisch",
    description="Deutsche Kreativ-Küche mit Fokus auf Fisch aus heimischen Gewässern. À la carte, Tagesgerichte und saisonale Spezialitäten direkt an der Ostsee.",
    content='''
<!-- HERO -->
<section class="subpage-hero">
  <div class="subpage-hero__media">
    <img src="assets/images/tile-alacarte.jpg" alt="À la carte bei gut salzig">
  </div>
  <div class="subpage-hero__content">
    <nav class="subpage-hero__breadcrumb">
      <a href="index.html">Home</a>
      <span class="sep">/</span>
      <span class="current">Küche & Speisekarte</span>
    </nav>
    <span class="subpage-hero__eyebrow">Donnerstag – Sonntag</span>
    <h1 class="subpage-hero__title">Aus unserer<br><em>Küche</em>.</h1>
    <p class="subpage-hero__sub">Deutsche Kreativ-Küche mit einem klaren Herz für Fisch aus heimischen Gewässern. Wöchentlich wechselnde Tagesgerichte, sorgfältig kuratierte À-la-carte-Karte und saisonale Spezialitäten — frisch, ehrlich, mit einer Prise Salz.</p>
  </div>
  <div class="subpage-hero__bar">
    <span>54°26′N · 10°14′E · Stein</span>
    <span class="subpage-hero__bar-flight">GS · KITCHEN · 2026</span>
    <span>Küchenzeiten: 17 – 20 Uhr</span>
  </div>
</section>

<!-- Tagesgerichte (dynamisch) -->
<section class="subpage-section">
  <div class="wrap">
    <div class="page-head reveal">
      <span class="eyebrow">Diese Woche</span>
      <h2>Tages-<em>gerichte</em>.</h2>
      <p>Unsere Tagesgerichte wechseln wöchentlich — abhängig davon, was der Kutter am Morgen anlandet und was die Saison hergibt. Jedes Gericht ist ein kleiner Moment gut salzig.</p>
    </div>

    <div class="celebrations__grid reveal-stagger" style="max-width: 1200px; margin-inline: auto;">
      <article class="celebration">
        <img src="assets/images/dish-2.jpg" alt="Ostsee-Dorsch">
        <div class="luggage-tag" aria-hidden="true">
          <span class="luggage-tag__number">No. 01</span>
          <span class="luggage-tag__label">Tagesfisch</span>
          <span class="luggage-tag__code">GS · DRS</span>
        </div>
        <div class="celebration__body">
          <h3>Ostsee-<em>Dorsch</em></h3>
          <p>Salzkartoffel-Stampf · Spinat · Senfbeurre — 24 €</p>
        </div>
      </article>
      <article class="celebration">
        <img src="assets/images/dish-3.jpg" alt="Wochengericht">
        <div class="luggage-tag" aria-hidden="true">
          <span class="luggage-tag__number">No. 02</span>
          <span class="luggage-tag__label">Vegetarisch</span>
          <span class="luggage-tag__code">GS · VEG</span>
        </div>
        <div class="celebration__body">
          <h3>Ofen-<em>Gemüse</em></h3>
          <p>Kichererbsen · Tahini · Minze — 17 €</p>
        </div>
      </article>
      <article class="celebration">
        <img src="assets/images/dish-1.jpg" alt="Signature Dessert">
        <div class="luggage-tag" aria-hidden="true">
          <span class="luggage-tag__number">No. 03</span>
          <span class="luggage-tag__label">Signature</span>
          <span class="luggage-tag__code">GS · SWT</span>
        </div>
        <div class="celebration__body">
          <h3>Signature-<em>Dessert</em></h3>
          <p>Sanddorn · weiße Schokolade · Hafer — 9 €</p>
        </div>
      </article>
    </div>
  </div>
</section>

<!-- À la carte Menü -->
<section class="subpage-section subpage-section--cream">
  <div class="wrap">
    <div class="page-head reveal">
      <span class="eyebrow">À la carte</span>
      <h2>Unsere <em>Karte</em>.</h2>
      <p>Eine kleine, sorgfältig kuratierte Auswahl — kein endloses Menü, sondern ausgewählte Klassiker und Kreativ-Gerichte. Alle Preise in Euro, inkl. MwSt.</p>
    </div>

    <div class="menu-card reveal">
      <div class="menu-card__section">
        <h3 class="menu-card__title"><em>Zum</em> Start</h3>
        <ul class="menu-card__list">
          <li><span class="dot"></span><span class="name">Salziger Fischteller</span><span class="leader"></span><span class="price">19</span></li>
          <li><span class="dot"></span><span class="name">Matjes · Räucherlachs · Nordsee-Krabben · Meerrettich-Crème</span><span class="leader"></span><span class="price">—</span></li>
          <li><span class="dot"></span><span class="name">Bruchetta mit Tomate, Basilikum &amp; Parmesan</span><span class="leader"></span><span class="price">9</span></li>
          <li><span class="dot"></span><span class="name">Kürbissuppe mit Sanddorn &amp; Kürbiskernöl</span><span class="leader"></span><span class="price">8</span></li>
          <li><span class="dot"></span><span class="name">Rote Bete Carpaccio mit Ziegenkäse &amp; Walnuss</span><span class="leader"></span><span class="price">12</span></li>
        </ul>
      </div>

      <div class="menu-card__section">
        <h3 class="menu-card__title"><em>Aus</em> dem Meer</h3>
        <ul class="menu-card__list">
          <li><span class="dot"></span><span class="name">Pannfisch Holsteiner Art mit Bratkartoffeln &amp; Senfsauce</span><span class="leader"></span><span class="price">22</span></li>
          <li><span class="dot"></span><span class="name">Ostsee-Dorsch auf Salzkartoffel-Stampf &amp; Spinat</span><span class="leader"></span><span class="price">24</span></li>
          <li><span class="dot"></span><span class="name">Scholle „Finkenwerder" mit Speck, Krabben &amp; Salzkartoffeln</span><span class="leader"></span><span class="price">26</span></li>
          <li><span class="dot"></span><span class="name">Labskaus mit Rollmops, Spiegelei &amp; Gurke</span><span class="leader"></span><span class="price">18</span></li>
        </ul>
      </div>

      <div class="menu-card__section">
        <h3 class="menu-card__title"><em>Vom</em> Land</h3>
        <ul class="menu-card__list">
          <li><span class="dot"></span><span class="name">Holsteiner Burger · Bio-Rind · Cheddar · Bratkartoffeln</span><span class="leader"></span><span class="price">18</span></li>
          <li><span class="dot"></span><span class="name">Kalbsschnitzel Wiener Art mit Kartoffelsalat</span><span class="leader"></span><span class="price">24</span></li>
          <li><span class="dot"></span><span class="name">Rumpsteak 250g mit Ofenkartoffel &amp; Kräuterbutter</span><span class="leader"></span><span class="price">32</span></li>
          <li><span class="dot"></span><span class="name">Spareribs mit BBQ-Glasur &amp; Coleslaw</span><span class="leader"></span><span class="price">21</span></li>
        </ul>
      </div>

      <div class="menu-card__section">
        <h3 class="menu-card__title"><em>Aus</em> dem Garten</h3>
        <ul class="menu-card__list">
          <li><span class="dot"></span><span class="name">Strandgarten-Bowl · Ofengemüse · Kichererbsen · Tahini</span><span class="leader"></span><span class="price">17</span></li>
          <li><span class="dot"></span><span class="name">Risotto mit Steinpilzen &amp; gehobeltem Pecorino</span><span class="leader"></span><span class="price">19</span></li>
          <li><span class="dot"></span><span class="name">Gnocchi mit Salbei-Butter &amp; gerösteten Walnüssen</span><span class="leader"></span><span class="price">16</span></li>
        </ul>
      </div>

      <div class="menu-card__section">
        <h3 class="menu-card__title"><em>Zum</em> Abschluss</h3>
        <ul class="menu-card__list">
          <li><span class="dot"></span><span class="name">Crème brûlée mit Vanille-Bourbon</span><span class="leader"></span><span class="price">8</span></li>
          <li><span class="dot"></span><span class="name">Sanddorn-Parfait mit weißer Schokolade</span><span class="leader"></span><span class="price">9</span></li>
          <li><span class="dot"></span><span class="name">Rote Grütze mit Vanillesauce</span><span class="leader"></span><span class="price">7</span></li>
          <li><span class="dot"></span><span class="name">Käse-Auswahl · regionale Sorten mit Früchtebrot</span><span class="leader"></span><span class="price">12</span></li>
        </ul>
      </div>
    </div>

    <div style="text-align:center; margin-top: 3rem;" class="reveal">
      <a href="kontakt.html" class="btn btn--primary">Tisch reservieren <span class="arrow">→</span></a>
    </div>
  </div>
</section>

<!-- Philosophie -->
<section class="parallax" data-parallax>
  <div class="parallax__bg" data-parallax-bg style="background-image:url('assets/images/hero-1.jpg')"></div>
  <div class="parallax__content reveal">
    <span class="eyebrow">Unsere Philosophie</span>
    <h2>Frisch aus der Region.<br><em>Jeden Tag.</em></h2>
    <p>Wir arbeiten mit Kuttern aus der Kieler Förde, Bauern aus der Probstei und Winzern aus der Pfalz. Was nicht regional ist, kommt aus direktem Handel. Was nicht saisonal ist, steht nicht auf der Karte.</p>
    <a href="feiern.html" class="btn btn--accent">Eure Feier planen <span class="arrow">→</span></a>
  </div>
</section>
'''
)
