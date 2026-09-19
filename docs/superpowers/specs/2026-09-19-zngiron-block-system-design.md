# zngiron block system — design

Date: 2026-09-19. Status: approved by user in conversation.

## Goal

Rebuild the Emerald Pool demo as a reusable FSE block system: a base block theme plus a
blocks plugin under the `zngiron` namespace, with a strict sizing contract so any client's
photos and copy fit without per-image tuning. Emerald Pool is the first brand configured on it.
The demo must showcase Gutenberg and Full Site Editing capability to the CTO.

## Decisions

- Clean rebuild of theme, blocks, patterns and CSS. Keep Docker env, Makefile, seed loader,
  scraped assets in `research/`, CPT/meta definitions (moved to config).
- Visual direction stays "night water" (dark grounds, sand, ember, Fraunces + Karla + mono),
  rebuilt on the layout contract. Palette, fonts and spacing are theme.json presets and are
  editable in Global Styles; blocks never use raw hex.
- Block namespace `zngiron`. Plugin `zngiron-blocks`, theme `zngiron-base`.
- Block titles in Title Case, generic names, one job each. No client-domain names.
- Simplify: fewer templates, parts, patterns and PHP files than today.
- Indentation: PHP 4 spaces; everything else 2 spaces, including JSON. Enforced by
  `.editorconfig`, Prettier and PHPCS (WordPress ruleset).
- No Tailwind. No jQuery. No modals, alerts or overlays. Reduced motion respected.
- Conventional Commits, no Co-Authored-By or generated-with trailers, never push.
- Sequential execution only, each stage a complete deliverable.

## Repo layout

```
wp-content/themes/zngiron-base/
  style.css  theme.json  templates/  parts/  patterns/  inc/  assets/{css,fonts,images}
wp-content/plugins/zngiron-blocks/
  zngiron-blocks.php  inc/  src/{blocks,components}/  build/  package.json
config/brand.json        post types, meta fields, locations, social, brand name
seed/  tools/  docs/  research/
```

## Sizing contract (the templating proof)

Widths: contentSize 720px, wideSize 1280px, full bleed. Root padding 24px mobile, 48px from
1024px, `useRootPaddingAwareAlignments: true`. Every section is a core Group `alignfull` with a
constrained inner layout. Spacing only from the theme.json spacing scale (6 steps).

Frame: every image or video sits in a Frame with a fixed `aspect-ratio` from
{21:9, 16:9, 3:2, 4:5, 1:1}. `object-fit: cover`; `object-position` editable per image with the
core FocalPointPicker. Product renders use `object-fit: contain` on a paper background
(`surface-alt`). No image ever sets the height of a layout.

Hero heights: `100svh`, `75svh`, `50svh`, offset by `--wp-admin--admin-bar--height`. Hero copy
lives in a fixed column, max 60ch, bottom-left; focal point defaults right so faces stay clear
of copy. Scrim gradient bottom-left always on for legibility.

Type: prose max 65ch. Display sizes are fluid with a hard max reached at 1440px so 1920 and
2560 do not scale further. Content stays centred inside wideSize with equal gutters.

Grid: CSS grid, 12 columns at wide, gutters from spacing presets, equal-height cards. Never
flex for card layouts. Navigation row is `nowrap`; the off-canvas breakpoint is set where the
full row (logo + items + phone + CTA) no longer fits, verified at 768/1024/1280/1440.

Motion: reveal is an opt-in class; elements are visible by default and only get a hidden start
state under `html.z-motion` set by a view script when IntersectionObserver is active. Header
pinned state is one class toggle; pinned colours are separate tokens with AA contrast.

## Theme (minimal)

- Templates: index, front-page, page, single, archive, 404, search. The CPT uses single and
  archive; post-type specific content comes from patterns and blocks, not extra template files.
- Parts: header, footer.
- Patterns: about ten, one per seeded page section, composed from the blocks below and core.
- inc/: setup.php, assets.php, patterns.php, block-styles.php. Namespaced functions.
- CSS: `tokens.css` (aliases presets to `--z-*`), `layout.css` (Section, Frame, grid, header
  states, reveal). Target under 400 lines total. Everything else expressed in theme.json.
- Fonts self-hosted via theme.json fontFace.

## Plugin: eleven blocks

All `apiVersion: 3`, server-rendered (`render.php`), `example` previews, supports for
align/spacing/color where fitting. Interactivity API only where marked.

1. Hero — Frame (image/video), eyebrow, heading, text, buttons, meta slot. Height option.
2. Media Text — Frame beside content, ratio option, side switch.
3. Card Grid — parent, 2 to 4 columns. Child Card: Frame, title, text, link. Replaces
   Feature Grid and Icon Feature.
4. Post Grid — dynamic query over any post type, renders Card markup, optional filter chips
   (Interactivity API).
5. Specs Table — key/value rows from the meta fields declared in config for the current post.
6. Compare Table — pick 2 to 3 posts, same meta fields side by side.
7. Stats — number, label, count-up (Interactivity API).
8. FAQ — items using `details`, FAQPage JSON-LD.
9. Testimonials — quote items, prev/next (Interactivity API), no autoplay.
10. Locations — address cards from config, tel and directions links.
11. Marquee — CSS text loop, pauses on hover, static under reduced motion.

Shared editor components in `src/components/`: Frame (ratio + focal point), Buttons, Eyebrow.

inc/: Plugin (bootstrap), Blocks (auto-register from build manifest), Config (reads
`config/brand.json`, filterable), PostTypes, Meta (register_post_meta with show_in_rest, used
via block bindings), Schema (Product JSON-LD on single CPT). Six files.

## Seed

`make seed` stays idempotent. Content files rewritten to use the new blocks and patterns.
Pages: Home, Hot Tubs, Swim Spas, Services, Financing, About, FAQ, Journal, Contact, Privacy,
Accessibility. 10 spa posts, 3 journal posts, navigation, logo, site icon.

## Verification

`tools/screenshot.js` (`make shots`): viewport shots at 390/768/1024/1440/1920/2560 for every
seeded page at top and at scroll offsets 1000/2600/5000, plus mobile nav open. Assertions:
`scrollWidth === clientWidth`; every element in viewport has computed opacity 1 after scroll;
nav renders one row on desktop widths; hero height equals viewport height; no console errors;
no PHP notices. axe color-contrast zero violations including pinned header. Link crawl zero
404s. `make reset && make install && make seed` reproduces the site.

## Out of scope

WooCommerce, contact form mailer, hover video footage, a second style variation file,
`/hot-tubs/<model>/` rewrite rules.

## Execution order (sequential, each stage complete on its own)

1. Plugin `zngiron-blocks` with config loader, eleven blocks, build committed, docs/BLOCKS.md.
2. Theme `zngiron-base`, patterns, seed rewrite, activation, screenshots and assertions.
3. Remove old theme and plugin, update ARCHITECTURE.md and CTO-SUMMARY.md.
