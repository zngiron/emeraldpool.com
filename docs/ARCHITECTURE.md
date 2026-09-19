# Architecture

The site is two pieces under one namespace:

- **`zngiron-blocks`** — a plugin: the content model, the brand data, and twelve
  server-rendered blocks (eleven sections plus the Card that Card Grid contains). It owns *what a section is*.
- **`zngiron-base`** — a block theme: presets, templates, parts and patterns. It owns
  *what a section looks like*.

Neither knows the client's name. The brand lives in `config/brand.json` and in the theme's
presets, which is what makes the pair reusable: a second client is a new `brand.json`, a new
palette and a new set of photographs, with no template or block edited.

## Folder map

```
config/brand.json                     brand name, post types, taxonomies, meta fields,
                                      locations, social. Read once, filterable.

wp-content/plugins/zngiron-blocks/
  zngiron-blocks.php                  bootstrap
  inc/Plugin.php                      wires the other five
  inc/Config.php                      reads config/brand.json
  inc/PostTypes.php                   registers post types and taxonomies from it
  inc/Meta.php                        register_post_meta + the specs/compare row builders
  inc/Blocks.php                      registers every block from the build manifest
  inc/Render.php                      Frame, Card, Buttons — the shared markup
  inc/Schema.php                      Product JSON-LD on the single catalogue page
  src/blocks/*/                       twelve blocks: block.json, edit.js, render.php, style.scss
  src/components/                     Frame, Buttons, Eyebrow (editor)
  src/frame.scss                      the Frame, Buttons and Eyebrow stylesheet
  build/                              compiled, committed

wp-content/themes/zngiron-base/
  style.css                           theme header only
  theme.json                          every design decision that can be a preset
  functions.php                       loads inc/
  inc/setup.php                       theme supports, head tidying
  inc/assets.php                      two stylesheets, one script, font preloads
  inc/patterns.php                    the three pattern categories
  inc/block-styles.php                eight core block styles, held as data
  assets/css/tokens.css               binds --z-* to theme.json presets
  assets/css/layout.css               section, hero, header, catalogue, footer, reveal
  assets/js/view.js                   header state + the reveal (~1 KB, deferred)
  assets/fonts/*.woff2                Fraunces, Karla, JetBrains Mono — self-hosted
  assets/images/                      the photographs the patterns preview with
  templates/                          index, front-page, page, single, archive, 404, search
  parts/                              header, footer
  patterns/                           fourteen patterns, one per seeded section

seed/                                 media.txt, spas.json, content/*.html, php/content.php
tools/screenshot.js                   `make shots`: six widths, four stops, five assertions
```

## The sizing contract

This is the part that makes the system templatable. It is the same six rules everywhere.

| | |
|---|---|
| Widths | `contentSize` 720px, `wideSize` 1280px, plus full bleed |
| Root padding | 24px, stepping to 48px at 1024px, with `useRootPaddingAwareAlignments` |
| Section | one core Group, `alignfull`, `.z-section`, constrained inner layout |
| Media | always a Frame with a fixed `aspect-ratio` from {21:9, 16:9, 3:2, 4:5, 1:1} |
| Hero | `100svh`, `75svh` or `50svh`, less the admin bar; copy max 60ch, bottom left |
| Grid | CSS grid, equal-height cards, gutters from the spacing scale. Never flex |

An image never sets the height of a layout: the ratio does, and `object-fit` decides what
happens inside it. `object-position` is editable per image with the core focal point picker,
so a client's photographs drop in without anyone retouching them to fit.

Two consequences worth knowing:

- **`box-sizing: border-box` is load-bearing.** Without it a Hero asking for `100svh` renders
  a viewport *plus* its own padding, and the first screen is never the first screen.
- **Product renders are not photographs.** Manufacturer plan renders are line drawings on
  white. They are contained on the `surface-alt` ground and multiplied, so every model is
  drawn to the same scale and none of them floats on a white rectangle.

Type is fluid between 360px and 1440px and stops there, so 1920 and 2560 are the same type at
a wider measure rather than a larger page. Prose is capped at 65ch by the element, not by the
column.

## Token aliases

Blocks never read a preset directly and never contain a raw value. They read `--z-*`, and
`assets/css/tokens.css` is the only place those are bound — always to a theme.json preset.

| Alias | Bound to |
|---|---|
| `--z-space-xs / -s / -m / -l` | spacing presets 20 / 30 / 40 / 50 |
| `--z-size-small / -eyebrow / -figure / -quote` | font sizes small / custom eyebrow / xx-large / large |
| `--z-font-display / -ui / -mono` | font families display / ui / mono |
| `--z-accent` / `--z-on-accent` | colours accent / abyss — a ground and the text that clears AA on it |
| `--z-on-dark` / `--z-muted` | colours sand / muted |
| `--z-surface-alt` / `--z-rule` | colours surface-alt / rule |
| `--z-scrim` / `--z-radius` | `settings.custom` scrim / radius |
| `--z-gutter` | the root padding step, 24px → 48px at 1024px |
| `--z-header-h` | the fixed header's height, republished by `view.js` |

Two contexts redefine a few of them and nothing else should: `.z-night`, where `--z-muted`
and `--z-rule` would otherwise fail contrast on the dark ground, and the pinned header.

## How to rebrand

1. **`theme.json`** — the palette, the three font families and their `fontFace` entries, the
   type scale and the six spacing steps. Keep the slugs; change the values. `--z-*` follows,
   and so does every block.
2. **`config/brand.json`** — the brand name, the post types and taxonomies, the meta fields
   and which of them appear in the Specs Table (`specs`) and the Compare Table (`compare`),
   the locations and the social links. Adding a meta field here adds it to both tables, to
   the card strip and to the Product schema, with no code change.
3. **`assets/`** — the three `.woff2` files, the logo, the favicon, and the photographs the
   patterns preview with. `inc/assets.php` preloads the fonts by name; that is the only list.
4. **`seed/`** — `media.txt`, `spas.json` and `content/*.html` are this demo's content. A real
   client site replaces them with its own, or drops the seed entirely.

Nothing else names a client. There is no client string in a template, a part, a block or a
stylesheet.

## Adding a block

```sh
cd wp-content/plugins/zngiron-blocks
mkdir src/blocks/my-block            # block.json, index.js, edit.js, render.php, style.scss
npm run build
```

`inc/Blocks.php` registers everything in the build manifest, so there is nothing to add to a
list. Four rules: `apiVersion: 3`; server-rendered from `render.php` so the editor preview and
the front end come from one template; an `example` so the inserter shows something real; and
every value a `--z-*` alias with a `--wp--preset--*` fallback, never a hex colour. If the block
shows an image it uses `Render::frame()`.

## Breakpoints

There are four, and each one exists for a reason rather than for a device.

| | |
|---|---|
| `40em` (640px) | a card grid goes from one column to two |
| `48em` (768px) | Media Text splits into two columns; the Hero leaves its phone type scale |
| `64em` (1024px) | root padding steps 24 → 48; the logo goes 36 → 48; three- and four-column grids appear |
| `1080px` | the navigation row stops fitting and becomes the off-canvas panel |

The last one is the only one that is measured rather than chosen. The row carries a logo, six
items, a phone number and a filled call to action; 1080px is where all of that last fits on one
line, verified at 768, 1024, 1280 and 1440. Core switches its own overlay at 600px, which is far
too early for that row, so `layout.css` overrides it.

## make shots

```sh
make shots                                   # six widths, every seeded page
make shots ARGS="--widths=390 --pages=home"  # one stop, while working
```

Viewport screenshots at 1:1 — never full-page, because scaling a whole page into one image hides
exactly the defects that matter. Six widths (390, 768, 1024, 1440, 1920, 2560), four scroll
positions (top, 1000, 2600, 5000) and the off-canvas navigation opened below 1080px. At every
stop it asserts:

1. `scrollWidth === clientWidth`, and names any element sticking out sideways;
2. every element on screen has computed opacity 1 once it has come to rest;
3. header text clears 4.5:1 against the header's own ground, in both of its states;
4. no button or chip label is wider than the box drawn for it;
5. one navigation row at desktop widths, the off-canvas toggle below;
6. a full-height Hero is exactly the viewport, ±2px;
7. no console errors.

Shots land in `.shots/` (ignored). `docs/screenshots/` is a curated twenty.

`make crawl` walks every internal link and image and fails on a 404 or a `#` placeholder.
`make axe` runs axe-core's `color-contrast` rule over every page at 1440 and 390, at the top
and scrolled, so the transparent-over-hero header and the solid pinned header are both measured.
