# Blocks

Nine blocks in `wp-content/plugins/emerald-pool-blocks`. All render on the server, so saved post
content never holds compiled markup. All are in the **Emerald Pool** inserter category and carry an
`example` for the inserter preview.

| Block | Purpose | Key attributes | Dynamic | Interactive |
|---|---|---|:-:|:-:|
| `emerald-pool/spa-hero` | Full-bleed page opening: image, scrim, eyebrow, heading, standfirst, buttons. | `eyebrow`, `heading`, `standfirst`, `headingLevel`, `mediaUrl`, `mediaAlt`, `focalPoint`, `overlayOpacity` (0–90), `minHeight` (vh), `contentAlign` | yes | no |
| `emerald-pool/spa-grid` | Grid of spas queried from the catalogue; optional browser-side series filter. | `spaType`, `series`, `numberOfItems`, `columns` (2–4), `orderBy`, `showFilters`, `showPrice`, `excludeCurrent` | yes | yes — Interactivity API |
| `emerald-pool/spa-specs` | The current spa's spec meta as a grouped `<dl>`. | `heading`, `showGroupHeadings`, `columns` (1–3) | yes | no |
| `emerald-pool/spa-comparison` | Two or three spas side by side in one `<table>`. | `postIds` (max 3, picked in the sidebar), `showImages`, `caption` | yes | no |
| `emerald-pool/feature-grid` | Parent for Feature blocks; sets the column count and icon treatment. | `columns` (2–4), `iconStyle` (`plain`/`badge`) | yes | no |
| `emerald-pool/icon-feature` | One value proposition: icon, title, sentence, optional link. Child of feature-grid. | `icon` (8-icon picker), `title`, `text`, `linkUrl`, `linkText` | yes | no |
| `emerald-pool/testimonial-slider` | Customer quotes, one at a time, moved by the reader. No autoplay. | `label` (accessible name); inner blocks are `core/quote` | yes | yes — Interactivity API |
| `emerald-pool/faq-accordion` | Questions as native `<details>`; publishes `FAQPage` JSON-LD. | `heading`, `emitSchema`; inner blocks are `core/details` | yes | no — browser disclosure |
| `emerald-pool/store-locator-card` | The shops: address, hours, `tel:` link, map link. | `location` (`''`/`eugene`/`bend`), `showHours`, `showMapLink`, `showNote`, `headingLevel`, `layout` (`cards`/`inline`) | yes | no |

## Notes

- **Editor previews.** The four data-driven blocks (`spa-grid`, `spa-specs`, `spa-comparison`,
  `store-locator-card`) preview through `ServerSideRender`, so the editor shows the real output
  rather than an approximation.
- **Interactivity.** Two `view.js` modules exist, both `@wordpress/interactivity`. `spa-grid` reads
  each chip's and card's series from its own `data-series` attribute instead of nesting contexts,
  which keeps the whole filter state in one root context. `testimonial-slider` marks off-screen
  slides `inert` so keyboard focus cannot land on a hidden quote, and announces position politely.
- **Shared CSS.** `spa-grid`, `spa-specs`, `spa-comparison` and `store-locator-card` declare the
  `emerald-pool-shared` handle in their `block.json` `style` array, so the chip and card primitives
  ship once and still load only when one of those blocks is on the page.
- **Structured data.** `Product` and `LocalBusiness` come from `inc/Schema.php`; `FAQPage` comes
  from `faq-accordion`'s `render.php`. The reasoning is in `docs/ARCHITECTURE.md` §2.

## Build

```sh
cd wp-content/plugins/emerald-pool-blocks
npm install
npm run build     # wp-scripts build --experimental-modules --blocks-manifest
npm run start     # watch
```

`build/` is committed: nothing downstream of this repository needs Node.
