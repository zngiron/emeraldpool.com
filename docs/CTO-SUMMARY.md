# Emerald Pool — what we built, and what it would take to ship it

A working WordPress block theme and block plugin, modelled on emeraldpool.com, running locally
with real content. Three commands from a clean machine to a seeded site. The point of the exercise
was to show what a modern Gutenberg build looks like next to the classic-theme site the business
runs today, and to show that the result is liftable onto the next client.

## What is in the box

**A block theme, `emerald-pool`.** `theme.json` v3 holds the whole design system — ten colours,
a type scale on two self-hosted variable fonts, a spacing scale, radii, shadows and layout widths.
Thirteen HTML templates, three template parts and fifteen patterns. No stylesheet anywhere contains
a hex value, and the options that let a design drift — custom colours, custom gradients, custom font
sizes, drop caps — are switched off in settings.

**A plugin, `emerald-pool-blocks`.** The `spa` post type, three taxonomies, ten spec fields and
nine custom blocks, all registered from config arrays rather than hand-written registration calls.
The block inventory, with attributes, is in `docs/BLOCKS.md`; the architecture and the rebrand
procedure are in `docs/ARCHITECTURE.md`.

**Seeded content.** Ten spa models with real scraped specifications, nine pages built from block
markup, three journal posts, the primary navigation, two store records and twenty media items
imported from the scrape. `make seed` is idempotent: it matches media on a meta key and every post
on its slug, so running it twice changes nothing.

## Before and after, on information architecture

The live site has nine top-level menu sections, about ninety-four links, and renders all of them into
every page. Three separate paths lead to the same hot tub. Product URLs are query strings —
`/models/detail/?unit_id=45078` — and the site publishes 4,090 of them in a sitemap while
`robots.txt` disallows around 180 query parameters, so it is submitting and blocking the same
catalogue at once. The homepage `<h1>` is the word "Homepage"; every page carries two `<h1>`s and
two identical contact forms; a placeholder email address, `johnSmith@coolMail.com`, is live in
production markup.

What replaces it is seven top-level items, two levels deep, no mega menu. Products live in one
place with readable permanent URLs (`/spas/bullfrog-x7/`, `/spa-type/hot-tubs/`,
`/series/x-series/`). Each page has exactly one `<h1>` and the homepage leads with a proposition
rather than a heading. There is one form on the entire site, inline on `/contact/`, with real
labels — no modal, no newsletter interrupt, no cookie wall, no exit-intent. The audit that produced
this is `docs/IA-UX-AUDIT.md`.

## Architecture worth noting

**`theme.json` is the single source of design truth.** Change the palette and every block, pattern
and stylesheet reskins at once, because they all consume `var(--wp--preset--*)`.

**The content model is configuration, not code.** `PostTypes::post_types()`, `Meta::fields()` and
`Locations::all()` are arrays behind filters. Adding a spec field is one array entry, and it then
appears in the spec list, on the card chips, in the comparison table, in the Product JSON-LD and in
the REST API, because all of them read the same array.

**Spec meta reaches the editor through core block bindings.** Because the meta keys are unprefixed
and `show_in_rest`, a paragraph on the single-spa template is bound to `spa_dimensions` with
`core/post-meta` — no shortcode, no template tag, and an editor can bind another field without a
developer.

**Two blocks are interactive and both use the Interactivity API.** The spa grid filters by series
without a page reload; the testimonial slider moves only when a reader moves it. **The theme
enqueues no JavaScript at all on the front end, and there is no jQuery on the page.** The live site
loads two copies of it.

**Weight, measured on the seeded home page:** 149 KB of CSS and 22 KB of JavaScript, against the
live site's single 610 KB combined stylesheet plus two jQuery copies and a third-party widget with
its API token in the page source. The HTML document is 139 KB in this local build, most of it
WordPress's unminified inline block styles with `SCRIPT_DEBUG` on; a production build with style
concatenation cuts that substantially.

**The rebrand path is content and tokens only.** `docs/ARCHITECTURE.md` §3 lists the files you touch
for a new client — palette, fonts, logo, pattern copy, store records, spec fields — and the far
longer list of files you do not. That separation is the actual deliverable here: the design is in
the theme, the knowledge is in the plugin, and neither needs the other to make sense.

## How to run it

```sh
make up        # wordpress + mariadb
make install   # core install, activate theme and plugin, permalinks
make seed      # media, spas, pages, journal, navigation
```

Then http://localhost:8080, admin `admin` / `admin`. Nothing needs PHP, MySQL, Node or wp-cli on the
host; `build/` is committed so a deploy never needs a Node toolchain.

## What it looks like

| Home | Hot tubs |
|---|---|
| ![Home, desktop](screenshots/home-desktop.png) | ![Hot tubs listing, desktop](screenshots/hot-tubs-desktop.png) |

| Single spa | FAQ |
|---|---|
| ![Single spa, desktop](screenshots/spa-single-desktop.png) | ![FAQ, desktop](screenshots/faq-desktop.png) |

| Contact | Mobile |
|---|---|
| ![Contact, desktop](screenshots/contact-desktop.png) | ![Home, mobile](screenshots/home-mobile.png) |

Every page was checked at 390px and 1440px: no console errors, no PHP notices, no horizontal
scroll, no overlays. The off-canvas navigation, the grid filter chips, the FAQ disclosures and the
slider controls were all exercised in the browser.

## What production would need next

**A mailer behind the contact form.** The form is real, labelled and accessible markup with no
handler. Production wants a POST endpoint, server-side validation, a spam control that is not a
visible honeypot, transactional delivery through something like Postmark or SES, and a stored copy
so a lost email is not a lost lead.

**A decision on commerce.** The business does not transact online today, and WooCommerce on the
live site is pure overhead — its cart, checkout and account pages are indexable and lead nowhere.
If commerce is wanted later, the `spa` post type maps onto Woo products cleanly: the spec meta
becomes product attributes, `spa_series` becomes a product category, and `spa-grid` swaps its query
for a product query while the card markup stays. If commerce is not wanted, Woo should be removed
and those pages 410'd.

**Rewrite rules for the audited URLs.** This build ships `/spas/<model>/`; the audit proposed
`/hot-tubs/<model>/`. That is a `spa_type`-aware rewrite plus a canonical redirect, deliberately
deferred because it carries redirect-map implications for 4,090 existing URLs. The migration map
from `/models/detail/?unit_id=N` to the new slugs is the larger piece of that work.

**CI.** PHPCS with the WordPress ruleset, `@wordpress/scripts` lint for JS and CSS, a block build on
every push with the compiled output diffed against the commit, and a smoke test that installs
WordPress, runs the seed twice and asserts the counts are unchanged — the seed is already written
to make that test possible.

**Then the production hygiene the current site lacks:** object caching and a CDN, an image pipeline
that ships AVIF/WebP at the sizes the cards actually request, a staging environment that mirrors
production, and automated accessibility checks in CI so the floor this build sets does not quietly
drop.
