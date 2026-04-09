build(
    slug="kontakt",
    title="Kontakt & Reservierung — gut salzig · Stein an der Ostsee",
    description="Reserviere deinen Tisch, plane deine Feier oder schick uns eine Postkarte. gut salzig, Uferkoppel 10, 24235 Stein.",
    content='''
<section class="subpage-hero">
  <div class="subpage-hero__media"><img src="assets/images/intro-gastraum.jpg" alt="Kontakt gut salzig"></div>
  <div class="subpage-hero__content">
    <nav class="subpage-hero__breadcrumb"><a href="index.html">Home</a><span class="sep">/</span><span class="current">Kontakt</span></nav>
    <span class="subpage-hero__eyebrow">Reservierung & Anfragen</span>
    <h1 class="subpage-hero__title">Besuch uns<br>am <em>Meer</em>.</h1>
    <p class="subpage-hero__sub">Reserviere deinen Tisch für Brunch, Abendessen oder eine Feier. Wir freuen uns auf dich.</p>
  </div>
  <div class="subpage-hero__bar">
    <span>Uferkoppel 10 · 24235 Stein</span>
    <span class="subpage-hero__bar-flight">04343 1859155</span>
    <span>flaschenpost@gut-salzig.de</span>
  </div>
</section>

<section class="contact" style="background: var(--bg);">
  <div class="wrap">
    <div class="contact__grid">
      <div class="photo-pair reveal">
        <div class="photo-pair__item"><img src="assets/images/visit-1.jpg" alt="Brunch-Moment"></div>
        <div class="photo-pair__item"><img src="assets/images/visit-2.jpg" alt="Gedeckter Tisch"></div>
      </div>
      <div class="reveal">
        <span class="eyebrow">So findest du uns</span>
        <h2>Direkt an<br>der <em>Förde</em>.</h2>
        <p>Uferkoppel 10, 24235 Stein. Parkmöglichkeiten direkt am Restaurant. Mit dem Auto über die B502 Richtung Laboe, Abfahrt Stein.</p>
        <div class="contact__info">
          <div><strong>Adresse</strong><span>Uferkoppel 10<br>24235 Stein</span></div>
          <div><strong>Telefon</strong><span>04343 1859155</span></div>
          <div><strong>E-Mail</strong><span>flaschenpost@<br>gut-salzig.de</span></div>
          <div><strong>Anfahrt</strong><span>B502 → Stein<br>Parkplätze vorhanden</span></div>
        </div>
        <a href="#" class="link" style="margin-top:2rem;">Route planen →</a>
      </div>
    </div>

    <form class="postcard reveal" onsubmit="event.preventDefault(); alert('Demo');">
      <div class="postcard__header">
        <span class="postcard__greetings">Greetings from <em>Stein</em>,</span>
        <span><strong>POST · GUT SALZIG</strong> · Airmail · Par Avion</span>
      </div>
      <div class="postcard__left">
        <label class="postcard__label" for="pc-msg2">Deine Nachricht</label>
        <textarea id="pc-msg2" class="postcard__message" placeholder="Hallo gut salzig, ich würde gerne…"></textarea>
        <div class="postcard__from"><label for="pc-from2">Von:</label><input id="pc-from2" type="text" placeholder="Dein Name"></div>
        <div class="postcard__visa" aria-hidden="true">
          <span class="postcard__visa-top">Entry Visa</span>
          <span class="postcard__visa-main">Cleared</span>
          <span class="postcard__visa-bottom">GS · Stein 2026</span>
        </div>
      </div>
      <div class="postcard__right">
        <div class="postcard__stamp-row">
          <div class="postcard__stamp"><div class="postcard__stamp-inner"><img src="assets/logo/icon-blk.svg" alt=""><div class="postcard__stamp-value">GS · 0,95</div><div class="postcard__stamp-region">Ostsee · DE</div></div></div>
          <div class="postcard__postmark"><div class="postcard__postmark-city">Stein</div><div class="postcard__postmark-date">Heute</div><div class="postcard__postmark-country">54°26′N · Ostsee</div></div>
        </div>
        <div class="postcard__to">
          <span class="postcard__to-label">An gut salzig — Absender</span>
          <div class="postcard__to-field"><label>Name</label><input type="text" placeholder="Max Mustermann" required></div>
          <div class="postcard__to-field"><label>Mail</label><input type="email" placeholder="du@beispiel.de" required></div>
          <div class="postcard__to-field"><label>Tel</label><input type="tel" placeholder="04343 …"></div>
          <div class="postcard__to-field"><label>Anlass</label><select><option>Tischreservierung</option><option>Sonntagsbrunch</option><option>Samstags-Frühstück</option><option>Event-Anfrage</option><option>Hochzeit</option><option>Firmenfeier</option><option>Andere Feier</option></select></div>
          <div class="postcard__to-field"><label>Datum</label><input type="date"></div>
        </div>
        <button type="submit" class="postcard__send">Postkarte abschicken <span class="arrow">✈</span></button>
      </div>
    </form>
  </div>
</section>
'''
)
