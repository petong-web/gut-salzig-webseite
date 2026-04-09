# gut salzig — Webseiten-Prototyp

Statischer HTML/CSS/JS-Prototyp als Design- und Strukturgrundlage für die neue Webseite von **gut salzig Beach Club & Restaurant** (Uferkoppel 10, 24235 Stein).

## Was dieser Prototyp enthält

- **Boho-Design-System** in `assets/css/style.css` mit CSS-Variablen für Farben, Typografie, Abstände, Schatten
- **Home-Seite** (`index.html`) mit folgenden Sektionen:
  1. Fixe Navigation mit Scroll-Transition (transparent → hell)
  2. Hero mit automatischem Fullscreen-Slider (Ken-Burns-Effekt)
  3. Intro-Sektion mit Galerie-Layout
  4. Parallax-Quote-Sektion
  5. Küche/Tagesgerichte als 3er-Karten-Grid
  6. Sonntagsbrunch-Feature mit Wochenmenü
  7. Events-Vorschau mit 3 Anmelde-Typen (Ticket / Reservierung / Info)
  8. Feiern-Mosaik (Hochzeit, Firmenfeier, JGA, Konfirmation, Babyparty, Weihnachtsfeier)
  9. Kontakt-Sektion mit Anfrage-Formular
  10. Footer mit Öffnungszeiten und Kontaktdaten
- **JavaScript** (`assets/js/main.js`): Slider, Parallax, Scroll-Reveal, Mobile-Menü, Smooth-Scroll

## Farbpalette (Ostsee-Boho)

| Zweck | Farbe | Hex |
|---|---|---|
| Hintergrund hell | Off-White / Sand | `#FBF8F3` |
| Creme | Warme Creme | `#F3EDE3` |
| Warmer Sand | Boho Sand | `#E8DFD1` |
| Text | Treibholz dunkel | `#2B2A26` |
| Akzent | Terrakotta | `#B8623D` |
| Grün | Salbei | `#8A9B7A` |
| Gold | Messing | `#C9A86B` |

## Typografie

- **Display / Headlines**: Cormorant Garamond (Serif, elegant)
- **Script / Eyebrow**: Caveat (handschriftlich)
- **Body**: Inter (sans-serif)

Alle Fonts werden über Google Fonts geladen — später gerne selbst hosten für DSGVO.

## Aktueller Stand & Platzhalter

- Bilder sind **Unsplash-Platzhalter** — sobald die echten Fotos im Ordner `Images-wordpress/uploads/` vorliegen, ersetzen wir sie
- Texte wurden teilweise von gut-salzig.de gezogen (Slogan, Kontaktdaten, Öffnungszeiten). Der Großteil sind Beispieltexte
- Formular ist nur Demo (noch kein Backend)

## Lokale Vorschau

Einfach `index.html` im Browser öffnen, oder einen kleinen lokalen Server starten:

```bash
cd prototype
python3 -m http.server 8080
# → http://localhost:8080
```

---

## Nächste Schritte / Roadmap

### Phase 1 — Design fertigstellen
- [ ] Echte Fotos einbauen (sobald Download fertig ist)
- [ ] Feintuning der Farbpalette auf Basis der echten Bilder
- [ ] Unterseiten: `/speisekarte`, `/brunch`, `/events`, `/feiern`, `/kontakt`, `/ueber-uns`
- [ ] Event-Detailseite mit Buchungs-/Reservierungs-/Info-Varianten
- [ ] Bewertungen-Widget (Google Reviews)

### Phase 2 — PHP-Backend (Eigenentwicklung)
Geplant als schlanker, eigener Stack — läuft auf jedem Standard-PHP-Hosting:

```
gut-salzig/
├── public/              ← Webroot
│   ├── index.php        ← Front-Controller
│   ├── assets/          ← CSS, JS, Fonts
│   └── uploads/         ← Upload-Ordner (Menüs, Events, Galerie)
├── app/
│   ├── core/            ← Router, DB (PDO), Auth, Session
│   ├── controllers/     ← HomeController, EventController, …
│   ├── models/          ← Event, BrunchMenu, DayDish, Booking, …
│   ├── views/           ← Templates (PHP)
│   └── config/
├── admin/               ← Mobile-optimiertes Admin-Panel
└── database/
    └── schema.sql
```

### Phase 3 — Admin-Panel (mobile-first, vom Handy pflegbar)
- Login (bcrypt, Session)
- CRUD für Events + Bild-Upload (WebP-Konvertierung, Resize)
- Wöchentliches Brunch-Menü
- Tagesgerichte
- Hero-Bilder & allgemeine Inhalte
- Anmeldungen/Reservierungen einsehen
- CSV-Export

### Phase 4 — Integrationen & Erweiterungen
- [ ] **Reservierungstool** — Verknüpfung mit bestehender Reservierungs-App, später eigene Logik
- [ ] **Newsletter** (Double-Opt-In, DSGVO-konform, ggf. mit Mailjet/Brevo)
- [ ] **Shop-System** (eigene Produkte oder WooCommerce-light via PHP)
- [ ] **Affiliate-System**
- [ ] **Kundenkartei & Kundenkarten** mit individuellen Rabatten
- [ ] **Ticket-Verkauf** für Events (Stripe-Integration)

### Phase 5 — SEO & Marketing
- [ ] OG-Tags, strukturierte Daten (Schema.org Restaurant, Event, LocalBusiness)
- [ ] Sitemap, robots.txt
- [ ] Performance: Lazy-Loading, WebP, Kritisches CSS inline
- [ ] Landing-Pages für Hauptkeywords:
  - Hochzeitslocation Kieler Förde / Ostsee
  - Brunch Kiel
  - Restaurant Stein Ostsee
  - Firmenfeier Ostsee
- [ ] Google Business Profile Integration
- [ ] Touristen-Zielgruppe: Mehrsprachigkeit (EN)

---

## Datenmodell (geplant, Vorschau)

```sql
events (id, title, slug, description, date, time, image, type, price, capacity, created_at)
event_bookings (id, event_id, name, email, phone, persons, status, created_at)
brunch_menus (id, week_start, title, image, description, menu_items JSON, published)
day_dishes (id, date, name, description, image, price, category)
hero_slides (id, image, title, subtitle, sort_order, active)
pages (id, slug, title, content, meta_description, updated_at)
contact_requests (id, name, email, occasion, date, message, status, created_at)

-- Später:
customers (id, name, email, phone, card_number, discount_percent, points)
newsletter_subscribers (id, email, confirmed, created_at)
products (id, name, price, image, stock, category)
orders (id, customer_id, total, status, created_at)
```

---

## Kontakt / Stammdaten

- **Name**: gut salzig Beach Club & Restaurant
- **Adresse**: Uferkoppel 10, 24235 Stein
- **Telefon**: 04343 1859155
- **E-Mail**: flaschenpost@gut-salzig.de
- **Küche**: Deutsche kreative Küche, Fokus auf Fisch
- **Öffnungszeiten**:
  - Do & Fr: 17 – 20 Uhr
  - Sa: À la carte 12 – 20 Uhr
  - So: Brunch 10 – 14 Uhr, Kaffee 14 – 17 Uhr, À la carte 15 – 20 Uhr
