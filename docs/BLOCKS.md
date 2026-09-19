# Blocks

Eleven blocks in `wp-content/plugins/emerald-pool-blocks`. All render on the server, so saved post
content never holds compiled markup. All are in the **Emerald Pool** inserter category and carry an
`example` for the inserter preview.

| Block | Purpose | Key attributes | Dynamic | Interactive |
|---|---|---|:-:|:-:|
| `emerald-pool/spa-hero` | Full-viewport page opening: image or muted clip, two scrims, eyebrow, heading, standfirst, buttons bottom-left, utility row bottom-right, scroll cue. | `eyebrow`, `heading`, `standfirst`, `headingLevel`, `mediaUrl`, `mediaAlt`, `videoUrl`, `focalPoint`, `overlayOpacity` (0–90), `minHeight` (svh), `contentAlign`, `metaHeading`, `metaBody`, `showScrollCue` | yes | no |
| `emerald-pool/spa-plan` | The current spa's render on its paper field, with the dimension annotation and the hover clip. The single-spa opening. | `showDimensions`, `showScale`; reads `postId` context | yes | no — hover only |
| `emerald-pool/spa-stats` | Figures about the business against a sticky heading. Each counts up once, on first sight. | `heading`, `standfirst`, `items` (value, label, prefix, suffix, format) | yes | yes — Interactivity API |
| `emerald-pool/spa-grid` | Grid of spas as plan sheets; optional browser-side series filter. | `spaType`, `series`, `numberOfItems`, `columns` (2–4), `orderBy`, `showFilters`, `showPrice`, `excludeCurrent` | yes | yes — Interactivity API |
| `emerald-pool/spa-specs` | The current spa's spec meta as a grouped `<dl>`. | `heading`, `showGroupHeadings`, `columns` (1–3) | yes | no |
| `emerald-pool/spa-comparison` | Two or three spas side by side in one `<table>`. | `postIds` (max 3, picked in the sidebar), `showImages`, `caption` | yes | no |
| `emerald-pool/feature-grid` | Parent for Feature blocks; sets the column count and icon treatment. | `columns` (2–4), `iconStyle` (`plain`/`badge`) | yes | no |
| `emerald-pool/icon-feature` | One value proposition: icon, title, sentence, optional link. Child of feature-grid. | `icon` (8-icon picker), `title`, `text`, `linkUrl`, `linkText` | yes | no |
| `emerald-pool/testimonial-slider` | Customer quotes, one at a time, moved by the reader. No autoplay. | `label` (accessible name); inner blocks are `core/quote` | yes | yes — Interactivity API |
| `emerald-pool/faq-accordion` | Questions as native `<details>`; publishes `FAQPage` JSON-LD. | `heading`, `emitSchema`; inner blocks are `core/details` | yes | no — browser disclosure |
| `emerald-pool/store-locator-card` | The shops: address, hours, `tel:` link, map link. | `location` (`''`/`eugene`/`bend`), `showHours`, `showMapLink`, `showNote`, `headingLevel`, `layout` (`cards`/`inline`) | yes | no |

## Notes

- **Editor previews.** The five data-driven blocks (`spa-grid`, `spa-specs`, `spa-comparison`,
  `store-locator-card`, `spa-plan`) preview through `ServerSideRender`, so the editor shows the real
  output rather than an approximation.
- **Interactivity.** Three `view.js` modules exist, all `@wordpress/interactivity`. `spa-grid` reads
  each chip's and card's series from its own `data-series` attribute instead of nesting contexts,
  which keeps the whole filter state in one root context. `testimonial-slider` marks off-screen
  slides `inert` so keyboard focus cannot land on a hidden quote, and announces position politely.
  `spa-stats` only replays numbers the server already printed, so the section is complete and
  correct before the module loads and for anyone who never gets it.
- **Hover video.** `spa-grid`'s cards and `spa-plan` both call `Media::video()`, which emits the
  element and enqueues `assets/media.js` — a plain script module, not the Interactivity API,
  because playing a clip changes no rendered state. Nothing downloads until a visitor asks:
  `preload="none"` plus `data-src` means there is no URL to fetch until the module supplies one.
  Set `spa_video_url` on a spa to switch it on; it is empty on the seeded catalogue because the
  live site has no per-model footage to mirror. `docs/ARCHITECTURE.md` §2c has the full contract.
- **Shared CSS.** `spa-grid`, `spa-specs`, `spa-comparison`, `store-locator-card`, `spa-stats` and
  `spa-plan` declare the `emerald-pool-shared` handle in their `block.json` `style` array, so the
  spec-figure and card primitives ship once and still load only when one of those blocks is on the
  page. The card takes its colours from two custom properties the surrounding section sets
  (`--ep-fg`, `--ep-line`), so one ruleset works on the light page and on the night ground.
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
