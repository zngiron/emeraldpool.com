# emeraldpool.com — IA / UX / UI / code audit, and the IA that shipped

Audited 2026-09-19 against the live site, then rebuilt. **The IA described here is delivered**: run
`make up && make install && make seed` and browse http://localhost:8080. Section 2 is the findings
from the live site, kept as the record of why the rebuild looks the way it does. Section 3 is the
shipped information architecture, and section 4 is the page-by-page plan the build followed.

The live stack at the time of the audit: WordPress 7.1.1, WooCommerce 11.1.1, classic PHP theme
`wordpress-spa-logic-hot-tubs-theme`, driven by the `spa-software-solutions` vendor catalog plugin
plus a per-client settings plugin. Hosting: SiteGround (SG Optimizer).

Raw extraction lives in `research/pages/*.md`, `research/site.json`, `research/spa-specs.json`,
`research/design-tokens.md`, `research/assets/manifest.json`. What the delivered system is made of
is in `docs/ARCHITECTURE.md`; what it looks like is in `docs/screenshots/`.

---

## 1. Current IA

**Scale (from sitemaps):** 92 pages · 73 posts · 122 WooCommerce products · 43 collection URLs ·
721 model-search URLs · **4,090 model-detail URLs** · plus separate sitemaps for inventory, parts,
locations, projects and careers (23 sitemap files in total).

**Navigation:** one mega menu, 9 top-level sections, ~94 links, all rendered into every page's HTML
(210 `<a>` on the homepage).

```
About Us        → About Us · Our Blog · Testimonials · Our Projects · Leave Us A Review
Our Locations   → All Locations · Eugene · Bend · Join Our Team
Bullfrog Spas   → All Types · Spas & Hot Tubs · Hot Tubs · Swim Spas · All Collections
                  · 6 series links (Swim / M / STIL / A / X / Calm)
                  · The Bullfrog Spas Difference → 5 feature pages · Hot Tub Benefits
Spas            → All Spas & Hot Tubs · Hot Tubs · In Stock Hot Tubs · Swim Spas
                  · Custom Spas · Hot Tub Chemicals
Pools           → All Pools · Above Ground · Custom · Renovation · Swim Spas · Pool Chemicals
Patio Furniture → Tables · Chairs · Umbrellas · Fire Tables · Patio Heaters · Elaine Smith Pillows
Grills          → (no children)
Hearth          → Fireplaces · Stoves · Fireplace Inserts · Log Sets
Services        → 20 links across General / Pool / Hearth / Hot Tub service groups
Chemicals       → 11 brand pages (BAQUACIL, Bioguard, Poolife, Frog, Leisure Time, Sirona, …)
Brands          → /models/
```

**Footer (every page):** Eugene store card · Bend store card · a full Contact Us form · newsletter
signup · © 2026 · Accessibility · Privacy · vendor credit.

---

## 2. Problems found

### 2.1 Information architecture

1. **Three overlapping paths to the same hot tub.** `Bullfrog Spas → Hot Tubs`, `Spas → Hot Tubs`
   and `Brands → /models/` all land on overlapping listings. "Swim Spas" appears under both *Spas*
   and *Pools*. Users cannot form a mental model of where a product lives.
2. **A 94-link mega menu is the site's only wayfinding.** No section landing pages that orient,
   no breadcrumbs, no in-page sub-nav. The menu is doing all the work and does it badly on mobile.
3. **Product URLs are query strings.** `/models/detail/?unit_id=45078`,
   `/models/?cat=1&brand=69&brandCollections=712`, `/collections/?category=9`. Not readable, not
   linkable in a human sense, and the site publishes 4,090 of them in a sitemap while `robots.txt`
   disallows ~180 query parameters — the site is simultaneously submitting and blocking its own
   catalog. That is the single largest SEO defect.
4. **Marketing and catalog are not separated.** Six Bullfrog "Difference" pages
   (JetPak, hydrotherapy, construction, energy savings, water care, benefits) are peers of
   commerce listings in the same menu column, so the story that actually sells the product is
   buried in a submenu.
5. **Dead-weight pages ship publicly.** `/mockup/`, `/grills-mockup/`, `/cart/`, `/checkout/`,
   `/my-account/` and `/shop/` are all in the public page sitemap. `Grills` is a top-level nav
   item with no children.
6. **Two stores, no local landing pages.** Eugene and Bend only exist as
   `/locations/detail/?location_id=123|124`. A two-location Oregon retailer has no indexable local
   page, no map embed, no per-store inventory view.

### 2.2 UX

7. **The homepage H1 is literally "Homepage"** (`<h1 class="entry-title">Homepage</h1>`). The page
   has no value proposition above the fold — the first real heading is "Explore Bullfrog Spas".
8. **Every page carries two H1s** (a hidden entry-title plus the visible one) and repeats the
   footer "Contact Us" heading twice — two identical contact forms render on every single page.
9. **A placeholder email is live in production markup: `johnSmith@coolMail.com`.** It appears in
   the form markup on every page audited.
10. **No price, no availability, no "next step" on product pages.** The spec table is the whole
    page. The only CTA path is the generic footer form.
11. **Filter UI dumps 8 facet groups with raw counts** ("Patio Furniture 3024 / Hearth 370 / …")
    above the products on `/hot-tubs/` — the listing leads with a wall of filters instead of product.
12. **Thin pages with heavy chrome.** `/financing/` is two sentences plus the ~90 KB of shared
    header/footer. `/services/` is a bare list of 20 link labels. The page-to-chrome ratio on most
    of the site is worse than 1:10.
13. **Testimonials leak into product pages.** The X7 model page's main content includes patio
    furniture and pool-cover reviews, unrelated to the spa being viewed.

### 2.3 UI / design

14. **Three competing colour systems in one stylesheet**: untouched Bootstrap 4
    (`--primary:#007bff`, 39 hits), the vendor's `--sss-*` defaults (gold `#c39d63`), and the
    client's `--emerald-pool-and-patio-*`. None of them is the brand blue by default.
15. **The brand tokens contradict themselves**: `--emerald-pool-and-patio-light-blue:#cbdded` but
    `--emerald-pool-and-patio-light-blue-rgb:75,197,225` (`#4bc5e1`). Two different blues depending
    on which var a component reads.
16. **No spacing scale.** 83 inline `style="…"` attributes and 16 `<style>` blocks on the homepage
    alone. Vertical rhythm is set per component.
17. **Six font families load per page**: Crimson Pro, Roboto, GeorgiaPro, Noto Sans, Font Awesome 5,
    a WooCommerce icon font — preloaded as raw `.ttf`, not `woff2`.

### 2.4 Code / performance

18. **No block usage.** The theme is classic PHP; 27 `wp-block-*` classes appear only because core
    emits them. WordPress writes `--wp--preset--*` variables the theme never consumes. No
    `theme.json`, no patterns, no FSE templates — the whole site is unmanageable from the editor.
19. **One 610 KB combined CSS file** produced by SG Optimizer, plus a combined JS bundle,
    **two copies of jQuery** (core's and one the SSS plugin ships from its own `includes/js/`),
    and a third-party Podium widget with an API token exposed in the page source.
20. **Average HTML document: 143 KB; homepage 194 KB** before any asset loads, most of it the
    repeated 94-link menu and the doubled footer form.
21. **Content pasted from Google Sheets.** Model spec tables carry **79 `data-sheets-value="{...}"`
    JSON attributes** per product page — clipboard residue serialised into production HTML. Specs
    are trapped in `<table>` markup with no structured data, so there is no schema.org Product
    output and no way to filter or compare on them except via the vendor's query-string engine.
22. **WooCommerce is installed and its cart/checkout/account pages are indexable, but the business
    does not transact online** — every path ends in a quote form. Pure overhead.
23. **Accessibility:** 35 form inputs to 10 `<label>` elements on the homepage; honeypot fields are
    exposed to screen readers with visible instructions ("Do not fill out this field otherwise your
    form will not submit properly."); duplicate H1s; heading order jumps H1 → H3 on listing pages;
    unlabeled filter controls. There is an `/accessibility/` page, which makes this worse, not better.

---

## 3. The IA that shipped

Marketing site only, **no WooCommerce**. Products are a `spa` custom post type with two taxonomies,
`spa_type` and `spa_series`, and clean permanent URLs.

```
/                             Home
/hot-tubs/                    Hot tubs — curated page: hero, filtered grid, compare table
/swim-spas/                   Swim spas — same shape
/spas/                        Every model (the post type archive)
/spas/<model>/                Single spa           e.g. /spas/bullfrog-x7/
/spa-type/<type>/             Type archive         hot-tubs · swim-spas
/series/<series>/             Series archive       a-series · m-series · x-series · stil · calm ·
                                                   swim-series
/services/                    Services
/financing/                   Financing
/about/                       About, including both showrooms
/journal/  /<post>/           Journal
/faq/                         FAQ
/contact/                     Contact — the one form on the site
/privacy/  /accessibility/    Policies
```

Navigation is six items and one button, two levels deep, no mega menu:

```
Hot Tubs   → All hot tubs · A Series · M Series · X Series · STIL · Calm · Every model
Swim Spas
Services
Financing
About      → Our story · Journal · FAQ
Contact                          [phone number, and a filled "Get a quote"]
```

Below 1080px that row becomes an off-canvas panel — measured, not chosen: 1080px is where a logo,
six items, a phone number and a filled call to action last fit on one line.

Two things in the audit were deliberately not shipped. Product URLs are `/spas/<model>/` rather than
`/hot-tubs/<model>/`, because the type-aware rewrite carries a redirect map for 4,090 existing
`/models/detail/?unit_id=N` URLs and that map is the real work. And the six "Difference" pages are
absorbed into `/about/` and `/services/` rather than into a separate `/why-bullfrog/`.

Redirects production will still need: every `/models/detail/?unit_id=N` to its new slug;
`/spas-hot-tubs/` and `/bullfrog-spas/` to `/hot-tubs/`; `/shop/`, `/cart/`, `/checkout/`,
`/my-account/`, `/mockup/` and `/grills-mockup/` to 410 or home.
---

## 4. Page-by-page section plan

The section order the build followed, page by page. Working names in **[block: …]** are from the
audit; what each became is in the table in section 5, and every section below is a pattern in
`wp-content/themes/zngiron-base/patterns/`.

### Home
1. Hero — full-bleed lifestyle image, H1 "Oregon's hot tub, pool and patio people since 1955", sub, dual CTA (Browse Hot Tubs / Book a Site Consultation). **[block: hero-media]**
2. Store bar — Eugene + Bend, today's hours, tap-to-call. **[block: location-bar]**
3. Featured spas — 3 cards pulled from the `spa` CPT, seats / jets / dimensions on the card. **[block: spa-grid]**
4. Series strip — 6 collection tiles (A · M · X · STIL · Calm · Swim).
5. Why Bullfrog — 3-up value props (JetPak personalisation · EnduraFrame · energy savings) with a link to `/why-bullfrog/`. **[block: feature-trio]**
6. Services teaser — 4 icon cards (Water Testing · Drain & Refill · Winterization · Repair).
7. Projects — custom pool gallery, 4 images.
8. Testimonials — 3 real reviews, name + source. **[block: testimonial-slider]**
9. Financing band — "0% for 12 months, subject to approval" + CTA.
10. Quote CTA — closing band. **[block: quote-cta]**

### Hot Tubs (listing)
1. Page header — H1 "Hot Tubs", one-sentence intro, breadcrumb.
2. Filter rail — seats, series, jets, pumps, features. Collapsed on mobile, **products visible first**. **[block: spa-filter]**
3. Spa grid — card = photo, model, series, seats, jets, water capacity, "View details". **[block: spa-grid]**
4. Series explainer — short paragraph per series with a link to the series landing.
5. Buying guide teaser — 3 blog links.
6. Quote CTA.

### Swim Spas (listing)
Same skeleton as Hot Tubs, with two differences: hero copy leads on swim-current/fitness, and the
card surfaces length, exercise seats and current type instead of jet count.

### Single Spa
1. Gallery + sticky summary rail — model, series badge, seats · jets · pumps · capacity, two CTAs (Request a Quote · See it in Eugene/Bend). **[block: spa-hero]**
2. Overview copy — 2 short paragraphs.
3. Spec table — from CPT meta, not pasted HTML. Standard + metric toggle. **[block: spec-table]**
4. Features — JetPaks, lighting, cover, water care, as an icon list from `spa_feature`. **[block: feature-list]**
5. Compare — "Others in the X Series", 3 cards. **[block: spa-grid]**
6. Financing band.
7. FAQ accordion (delivery, electrical, site prep). **[block: faq-accordion]**
8. Quote CTA.
Schema: `Product` + `Offer` JSON-LD emitted by the block.

### About
1. Hero — team photo, H1 "Family-run since 1955".
2. Story — the Grandpa Neely → third generation narrative, with a timeline. **[block: timeline]**
3. Why choose Emerald — 4 proof points.
4. Team grid.
5. Both stores — cards with photo, hours, map link. **[block: location-bar]**
6. Careers teaser → `/careers/`.
7. Quote CTA.

### Contact
1. Header — "How can we help?"
2. Two-column: single form (with real labels, visually-hidden honeypot) | store details, hours, map.
3. Direct routes — Service Repair · Parts Request · Site Consultation · Trade-In Value as four cards.
4. FAQ teaser.

### Services
1. Header + intro.
2. Four service groups as cards with descriptions, not bare links: Pool · Hot Tub · Hearth · General. **[block: service-cards]**
3. Service area map — Eugene and Bend radius.
4. "What happens when you book" — 3-step process. **[block: process-steps]**
5. Quote CTA.

### Financing
1. Header.
2. Terms explainer — 3 cards (term length, typical payment, what you need to apply).
3. Payment estimator — seats/price slider, illustrative only. **[block: payment-estimator]**
4. Wells Fargo partner note + disclosure.
5. Apply CTA + FAQ accordion.

### Blog
1. Header + category pills (Buying Guides · Maintenance · Seasonal · News).
2. Featured post — large card.
3. Post grid — 9, paginated.
4. Newsletter band.
Single post: hero image, byline, reading time, prose (wide/full images), related posts, quote CTA.

### FAQ
1. Header + search field.
2. Accordion grouped by Buying · Delivery & Install · Water Care · Service · Financing. **[block: faq-accordion]**
3. "Still stuck?" → `/contact/`.
Schema: `FAQPage` JSON-LD.

---

## 5. What the audit's blocks became

Twelve blocks shipped, namespace `zngiron`. The audit's working names map onto them like this:

| Audit name | Shipped as |
|---|---|
| `hero-media` | `zngiron/hero` |
| `spa-grid` + `spa-filter` | `zngiron/post-grid` — any post type, optional taxonomy filter chips |
| `spec-table` | `zngiron/specs-table`, plus `zngiron/compare-table` for models side by side |
| `location-bar` | `zngiron/locations` |
| `quote-cta` | core Buttons through the shared `Render::buttons()` — it never needed a block |
| `faq-accordion` | `zngiron/faq`, with FAQPage JSON-LD |
| `testimonial-slider` | `zngiron/testimonials` |
| `payment-estimator` | not built — a finance calculator is a regulated-copy decision, not a build task |

Five more arrived that the audit did not name: `zngiron/media-text`, `zngiron/card-grid` and its
`zngiron/card`, `zngiron/stats` and `zngiron/marquee`. The full inventory with attributes is in `docs/BLOCKS.md`.

`theme.json` supplies the palette, type scale and spacing scale from `research/design-tokens.md`,
so none of these blocks ships its own colours.
