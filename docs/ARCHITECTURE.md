# Architecture

Two deliverables, one rule between them.

**The theme owns how it looks. The plugin owns what it knows.**
Change the theme and the catalogue survives. Drop the plugin and the design is untouched.
That line is what makes this pair liftable onto another client.

---

## 1. Folder map

```
wp-content/themes/emerald-pool/
├── style.css                     Theme header only. No rules live here.
├── theme.json                    The single source of design truth (v3).
├── functions.php                 12 lines: requires inc/*.
├── inc/
│   ├── setup.php                 Theme supports + brand_config() — the rebrand file.
│   ├── assets.php                Stylesheet loading, per-block + font preload.
│   ├── patterns.php              Pattern categories; removes core/remote patterns.
│   ├── block-styles.php          register_block_style() for core blocks, as data.
│   ├── block-variations.php      Enqueues the editor variation script.
│   └── template-parts.php        Registers the extra "band" part area.
├── templates/                    13 HTML templates, all thin.
├── parts/                        header, footer, cta-band.
├── patterns/                     14 PHP patterns — where the page content lives.
└── assets/
    ├── fonts/                    2 self-hosted variable woff2 (92 KB total).
    ├── images/                   21 images, only those a pattern references.
    ├── js/block-variations.js    Editor-only. Nothing ships to the front end.
    └── css/
        ├── theme.css             Global layer: focus, skip link, motion, the form.
        └── blocks/*.css          One file per core block, loaded on demand.

wp-content/plugins/emerald-pool-blocks/
├── emerald-pool-blocks.php       Plugin header + one call to Plugin::boot().
├── package.json                  wp-scripts build/start.
├── inc/
│   ├── Plugin.php                The only list of subsystems.
│   ├── PostTypes.php             CPT + taxonomies from a config array.
│   ├── Meta.php                  Spec fields from a config array.
│   ├── Locations.php             Store data.
│   ├── Icons.php                 The eight-icon set, in PHP.
│   ├── Cards.php                 The spa card, shared by two blocks.
│   ├── BlockCategory.php         One inserter category.
│   ├── Blocks.php                One loop registers every compiled block.
│   ├── Schema.php                Product + LocalBusiness JSON-LD.
│   └── Assets.php                Shared style handle + icon publishing.
├── assets/shared.css             Chip and card primitives used by 3 blocks.
├── src/blocks/<name>/            block.json, index.js, edit.js, save.js|render.php,
│                                 style.scss, editor.scss, view.js (interactive only).
└── build/                        COMMITTED. Phase 3 and deploys need no Node.
```

---

## 2. Principles

**theme.json first.** Colour, type, spacing, radius, shadow and layout are declared once,
in `theme.json`, and consumed everywhere as `var(--wp--preset--*)` and `var(--wp--custom--*)`.
No block, pattern or stylesheet contains a hex value. Options that fragment a design
— custom colours, custom gradients, custom font sizes, custom spacing, drop caps — are
switched off, so an editor cannot invent a fourteenth blue.

**Patterns over templates.** A template says *which sections, in what order*. A pattern says
*what the section is*. Templates are four to eight lines long; content lives in
`patterns/*.php`, which are PHP and can therefore reference `get_theme_file_uri()`. Rearranging
a page is reordering pattern references.

**Dynamic blocks over static.** All nine custom blocks render on the server. Saved post content
holds only the editable inner blocks and the attributes. The pay-off: the markup of a block can
change in a later release without invalidating a single saved post, and a pattern file can write
`<!-- wp:emerald-pool/spa-hero {...} /-->` without hand-copying compiled save output.

**Config-driven content model.** `PostTypes::post_types()`, `PostTypes::taxonomies()`,
`Meta::fields()`, `Locations::all()` and `Icons::all()` are arrays. The registration loops beneath
them never change. A new spec field appears in the spec list, the comparison table and the Product
schema at once, because all three read `Meta::fields()`.

**One concern per file.** Every `inc/` file does one job and says so in its header. No file
requires reading another to understand.

**No jQuery, no modals, no overlays.** Two blocks are interactive and both use the Interactivity
API (`spa-grid` filtering, `testimonial-slider`). The theme enqueues no JavaScript at all on the
front end. There is exactly one form on the site, inline, on the contact page: no pop-up, no
cookie wall, no newsletter interrupt, no exit-intent. The mobile navigation is an off-canvas
panel, opened by the visitor.

**Accessibility as a floor, not a feature.** One `<h1>` per template, semantic landmarks
(`<header>`, `<main>`, `<footer>`, `<section>`), the core skip link, a visible 3px focus ring on
every interactive element, `prefers-reduced-motion` honoured, real `<dl>` for spec pairs and a real
`<table>` with `scope` for the comparison, off-screen carousel slides made `inert`, and a polite
live region for filter results.

**Structured data lives with the data.** `Product` and `LocalBusiness` are emitted by the plugin
(`inc/Schema.php`) because the plugin owns the post type and the meta they describe: change theme
and the markup survives; remove the plugin and it correctly disappears. `FAQPage` is the exception
and is emitted by `faq-accordion`'s own `render.php`, because it describes that block's inner
content rather than the post.

---

## 3. Rebranding for a new client — about an hour

### Files you change

| File | What to change | Time |
|---|---|---|
| `theme.json` | `settings.color.palette` (10 slugs, keep the names), `fontFamilies` + `fontFace` paths, `spacingSizes` if the client's rhythm differs, `layout` widths. | 20 min |
| `assets/fonts/` | Drop in two woff2 files, delete the old ones. | 5 min |
| `inc/assets.php` | The two filenames in `preload_fonts()`. | 1 min |
| `inc/setup.php` | `brand_config()`: name, tagline, phone, logo path. | 5 min |
| `assets/images/` | Replace `logo.png`, `favicon.ico`, the heroes and the product shots. | 10 min |
| `patterns/*.php` | The copy. Structure stays; you are editing sentences and image filenames. | 20 min |
| `parts/footer.html` | The four column link lists and the legal line. | 5 min |
| Plugin `inc/Locations.php` | The client's shops. | 3 min |
| Plugin `inc/PostTypes.php` | Rename `spa` and its taxonomies if the client sells something else. | 5 min |
| Plugin `inc/Meta.php` | The spec fields for that product. | 10 min |

### Files you do not touch

`style.css` · `functions.php` · `inc/assets.php` (beyond the font names) · `inc/patterns.php` ·
`inc/block-styles.php` · `inc/block-variations.php` · `inc/template-parts.php` ·
every file in `templates/` · `assets/css/**` · every `src/blocks/**` file ·
`inc/Plugin.php` · `inc/Blocks.php` · `inc/Cards.php` · `inc/BlockCategory.php` · `inc/Assets.php` ·
`inc/Schema.php` · `assets/shared.css`.

That is the test of the architecture: the rebrand list is content and tokens, and the do-not-touch
list is all the code.

### Checklist

1. `cp -r wp-content/themes/emerald-pool wp-content/themes/<client>` and edit the `style.css` header.
2. Rewrite `theme.json` palette and fonts. Load the site: everything reskins at once.
3. Swap the images, then edit the pattern copy.
4. Update `Locations::all()`, `Meta::fields()`, and the post type labels/slug.
5. `npm run build` in the plugin only if you changed a block. Rebranding does not need it.
6. Check one page of each template, and tab through the header.

---

## 4. How to add a block

1. `mkdir src/blocks/<name>` and write `block.json` with `"apiVersion": 3`,
   `"category": "emerald-pool"`, a real `description`, a useful `example` for the inserter preview,
   and `supports` that match what the block is for.
2. `index.js` registers it. `edit.js` is the editor. For a data-driven block use
   `render.php` plus `ServerSideRender` in the editor, so the preview is the real output.
3. Styles: `style.scss` for both sides, `editor.scss` for editor-only affordances. Use only
   theme.json variables. If you need a chip or a card, list `"emerald-pool-shared"` in the
   block.json `style` array rather than writing a third copy.
4. Interactive? Add `"viewScriptModule": "file:./view.js"` and `"supports": {"interactivity": true}`,
   and use `@wordpress/interactivity`. No other library is permitted.
5. `npm run build`. The block registers itself: `inc/Blocks.php` loops over
   `build/blocks-manifest.php` (WordPress 6.8+) or `build/blocks/*/block.json`. There is no list
   to update.
6. Add a row to `docs/BLOCKS.md`.

## 5. How to add a post type, taxonomy, spec field or icon

- **Post type or taxonomy:** one entry in `PostTypes::post_types()` or `PostTypes::taxonomies()`.
  `default_terms` seeds the terms on first load. Flush rewrites once.
- **Spec field:** one entry in `Meta::fields()` with a `label`, `type`, `group` and optionally
  `suffix` and `primary`. It then appears in the spec list, on the card chips (if `primary`), in the
  comparison table, in the Product schema and in the REST API — and, because the keys are
  unprefixed and `show_in_rest`, it is immediately available to core **block bindings**
  (`core/post-meta`) in the editor. `templates/single-spa.html` already binds a paragraph to
  `spa_dimensions` as the worked example.
- **Icon:** one entry in `Icons::all()`. The editor picker reads the same array through the
  `emerald-pool-icons` script, so there is no second copy of the artwork in JavaScript.
- **Store:** one entry in `Locations::all()`.

Every one of these arrays is behind a filter (`emerald_pool_post_types`, `emerald_pool_spa_fields`,
`emerald_pool_locations`, `emerald_pool_icons`, `emerald_pool_brand_config`), so a site-specific
plugin can extend them without forking.

---

## 6. Known deviations from `docs/IA-UX-AUDIT.md`

- **URLs.** The audit proposed `/hot-tubs/<model>/`. Achieving that needs per-term permalink
  rewriting, which is a production concern with redirect implications. This build ships
  `/spas/<model>/`, `/spa-type/hot-tubs/` and `/series/x-series/` — clean, readable and permanent.
  The mapping to the audit's URLs is a rewrite rule, not an architecture change.
- **`spa-filter` and `payment-estimator`** from the audit's block table were dropped. Filtering is
  built into `spa-grid` (chips, Interactivity API, no reload), which is the same feature without a
  second block. The estimator was cut for scope.
- **`spa-hero` is generic.** The audit sketched it as the single-spa summary rail; here it is the
  reusable page hero, and the single-spa summary is composed from core blocks plus block bindings,
  which is more editable.
- **The contact form is markup only.** It is a real, labelled, accessible, inline form with no
  mail handler wired up. Connecting it to a mailer is a production task.
