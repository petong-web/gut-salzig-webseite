# BRAND.md -- gut salzig Beach Club & Restaurant
> Design-Referenz fuer Claude (Chat & Code). Immer aktuell halten.
> GitHub-Pfad: `/BRAND.md` im Root des Projekts.

---

## Farben

Palette direkt aus den echten Gastraum-Fotos gesampelt:
Quelle: Waende (#D9B4A1), Holz-Tische (#422112), Samtstuehle (#E0D0C3), Messing-Pendants.

```
Background:        #FBF5EC   Warm Off-White mit Pfirsich-Hauch  (--bg)
Background 2:      #F4E6D1   Warm Cream, wie der Boden           (--bg-2)
Background 3:      #E9CEB9   Sand, wie Samtstuehle               (--bg-3)
Background 4:      #D9B4A1   Terrakotta, wie Wand                (--bg-4)
Surface:           #FFFFFF   Karten, Panels                      (--surface)

Text Primary:      #1F140C   Reiches Treibholz-Braun             (--ink)
Text Secondary:    #3C2A1B   Mittel-Braun                        (--ink-2)
Text Soft:         #6B5A45   Gedaempftes Braun                   (--ink-soft)
Text Muted:        #9E8E75   Helles Muted                        (--ink-mute)

Border:            #E9DBC4   Standard-Trennlinie                 (--line)
Border Soft:       #F3E9D4   Subtile Trennlinie                  (--line-soft)

Accent / CTA:     #C97552   Warme Terrakotta (Buttons, Links)   (--accent)
Accent 2:          #E09A6E   Helles Sunset                       (--accent-2)
Sage:              #8B9B78   Salbeigruen                         (--sage)
Ocean:             #6E8B91   Gedaempftes Ozean-Blau              (--ocean)
Gold:              #B8925A   Messing (Pendant-Leuchten)          (--gold)
```

---

## Typografie

```
Display Font:   Fraunces (variable, opsz 9-144)   -- Headlines, Titel
                Fallback: Cormorant Garamond, Georgia, serif
                Gewicht: 300 (light), Stil: italic fuer Headlines
                CSS: var(--ff-display)

Body Font:      Inter                               -- Fliesstext, Labels, UI
                Fallback: -apple-system, Segoe UI, sans-serif
                Gewicht: 300 (light), 400 (regular), 500 (medium)
                CSS: var(--ff-sans)

Script Font:    Tangerine                           -- Dekorative Akzente
                Fallback: Caveat, cursive
                CSS: var(--ff-script)

Brand Font:     Kulacino Rough (Custom OTF)         -- Nur Logo & Brand-Momente
                Fallback: Fraunces, serif
                Quelle: /prototype/assets/logo/KulacinoRough.otf
                CSS: var(--ff-brand)

Mono Font:      IBM Plex Mono                       -- Tickets, Flughafen-UI, Labels
                Fallback: JetBrains Mono, ui-monospace, monospace
                CSS: var(--ff-mono)

Heading 1:      clamp(2.6rem, 5.5vw, 5.8rem)   weight: 300  italic   (--fs-h1)
Heading 2:      clamp(2rem, 3vw, 3.4rem)        weight: 300  italic   (--fs-h2)
Heading 3:      clamp(1.25rem, 1.3vw+0.8rem, 1.8rem)  weight: 300    (--fs-h3)
Hero Title:     clamp(2.8rem, 7vw, 8rem)         weight: 300  italic
Body:           1.0625rem / 17px                 weight: 300            (--fs-body)
Small:          0.78rem / 12.5px                 weight: 400            (--fs-small)
XS / Labels:    0.68rem / 10.9px                 weight: 500            (--fs-xs)
```

---

## Logo

```
Logo Variante 1 (vertikal):
  Standard:     /Logo Gut salzig/GutSalzig_Logo1.svg
  Schwarz:      /Logo Gut salzig/GutSalzig_Logo1_blk.svg
  Weiss:        /Logo Gut salzig/GutSalzig_Logo1_wht.svg

Logo Variante 2 (horizontal, primär verwendet):
  Standard:     /Logo Gut salzig/GutSalzig_Logo2.svg
  Schwarz:      /Logo Gut salzig/GutSalzig_Logo2_blk.svg   (Nav scrolled, Overlay)
  Weiss:        /Logo Gut salzig/GutSalzig_Logo2_wht.svg    (Nav auf Hero, Footer)

Icon (fliegender Fisch):
  Standard:     /Logo Gut salzig/GutSalzig_Icon.svg
  Schwarz:      /Logo Gut salzig/GutSalzig_Icon_blk.svg     (Favicon)
  Weiss:        /Logo Gut salzig/GutSalzig_Icon_wht.svg      (Footer Mark, Postkarte)

Prototype-Pfade:
  /prototype/assets/logo/logo2-wht.svg        Nav (Hero)
  /prototype/assets/logo/logo2-blk.svg        Nav (scrolled)
  /prototype/assets/logo/icon-blk.svg         Favicon, Briefmarke
  /prototype/assets/logo/icon-wht.svg         Footer
  /prototype/assets/logo/KulacinoRough.otf    Brand-Font

Mindestgroesse:   32px Hoehe (Nav), 18px (Footer-Bottom)
Schutzraum:       mind. 50% der Logo-Hoehe ringsum
```

---

## Layout & Abstände

```
Max. Breite:        1360px   (--wrap)
Max. Breite Wide:   1560px   (--wrap-wide)
Border Radius:      2px      (Buttons, Cards -- bewusst eckig/editorial)
Border Radius SM:   4px      (--r-sm)

Animation Ease:     cubic-bezier(0.22, 1, 0.36, 1)   (--ease)
Animation Ease Out: cubic-bezier(0.16, 1, 0.3, 1)    (--ease-out)
Animation Dauer:    700ms standard, 360ms schnell

Nav Hoehe:          90px (Hero), 74px (scrolled), 72px (mobile)
Nav Scrolled:       Frosted Glass: rgba(255,255,255,0.65) + blur(32px) saturate(1.8)

Sektions-Padding:   clamp(5rem, 10vw, 10rem)
```

---

## Stil & Aesthetik

```
Stil:           Coastal Boho + Travel/Airline Thematik
Stimmung:       Warm, entschleunigt, premium, editorial
Claim:          "...wie ein Tag Urlaub am Meer"
Bildsprache:    Foerder-Strand, Pendel-Leuchten, Pampasgras,
                Treibholz-Tische, Hexagon-Fliesen, Trockenblumen,
                warmes natuerliches Licht, Brunch-Spreads
Color-Grade:    Warm peach/terrakotta Toning (alle Fotos einheitlich)

Travel-Elemente (durchgehend):
  - Boarding Pass Tickets fuer Events
  - Postkarte als Kontaktformular
  - Passport-Stempel als Section-Akzente
  - Flight Schedule als Oeffnungszeiten
  - IATA Codes (STN=Stein, SOM, WIN, YOG, FIS)
  - Departure Board mit Live-Uhr
  - Cockpit Weather Widget
  - Boarding Sound (E5->C5 Gong via Web Audio API)
  - Luggage Tags fuer Speisekarten-Kategorien
  - Flight Vouchers als Gutscheine (Economy/Business/First)
  - Newsletter als "Boarding Pass"
  - Captain's Log als News-Sektion

Keine:          Bunte Farben, Cartoon-Elemente, kindliche Icons,
                dunkle Themes (nur Footer + Nav-Overlay),
                runde Pill-Buttons, Stock-Fotos
```

---

## Social Media

```
Handle:         @gut_salzig (angenommen)
Hashtags:       #gutsalzig #kielerfoerde #staysalty #brunchamstrand
                #wieeintagurlaub #beachclub #steinostsee #ostseekueche
Bildformat:     1:1 Feed / 9:16 Story / 16:9 Header
Primaerfarbe:   #C97552 (Terrakotta)
Caption-Ton:    Du-Form, herzlich, kuestenlocker, kurze Saetze
Emoji-Stil:     (maritim, dezent, nicht ueberladen)
```

---

## Links & Kontakt

```
Website:        https://gut-salzig.de
GitHub:         https://github.com/petong-web/gut-salzig-webseite
E-Mail:         flaschenpost@gut-salzig.de
Telefon:        04343 1859155
Adresse:        Uferkoppel 10, 24235 Stein, Schleswig-Holstein
Koordinaten:    54 26'N, 10 14'E
```

---

## Oeffnungszeiten (Flight Schedule)

```
Mo-Mi:          Ruhetag (Closed)
Do & Fr:        17:00 - 20:00 Uhr (A la carte)
Samstag:        09:00 - 20:00 Uhr (Fruehstueck ab 09, A la carte)
Sonntag:        10:00 - 20:00 Uhr (Brunch 10-14, Kaffee 14-17, Abend 15-20)
```

---

## Seitenstruktur

```
index.html          Home (Hero, Tiles, Intro, Brunch, Parallax, Kueche,
                    Events, Feiern, Gallery, Captain's Log, Testimonials,
                    Vouchers, Newsletter, Kontakt, Footer)
brunch.html         Fruehstueck Sa + Brunch So (Detail + Karte + FAQ)
kueche.html         Speisekarte (Tagesgerichte + A la carte mit Preisen)
events.html         Events-Liste (Departure Board + Flight Search + 6 Tickets)
feiern.html         Hochzeiten & Feiern (6 Feier-Typen + Anfrage-CTA)
galerie.html        Foto-Galerie (9 Bilder im Celebration-Grid)
kontakt.html        Kontakt (Photo-Pair + Adresse + Postkarten-Formular)
impressum.html      Impressum (Platzhalter)
datenschutz.html    Datenschutz (Platzhalter)
```

---

## Nutzung mit Claude

Wenn du diese Datei in einen Chat mit Claude einfuegst (oder die GitHub-URL nennst),
kann Claude sofort im richtigen Brand-Stil arbeiten -- fuer:
- Website-Komponenten & neue Sektionen
- Instagram-Anzeigen & Posts
- Print-Grafiken & Flyer
- Texte & Captions
- Backend/Admin-Panel Design
- E-Mail-Templates (Boarding Pass Bestaetigung)
