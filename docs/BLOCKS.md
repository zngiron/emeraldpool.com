# Blocks

Twelve blocks in `wp-content/plugins/zngiron-blocks`, namespace `zngiron`,
category **zngiron**. All `apiVersion: 3` and server-rendered from `render.php`,
so what the editor previews and what a visitor gets come from one template.
Interactivity API is used by three of them and nowhere else; there is no jQuery.

| Title | Name | Purpose | Key attributes | Dynamic | Interactive |
| --- | --- | --- | --- | --- | --- |
| Hero | `zngiron/hero` | Opening section: Frame behind a fixed copy column, scrim always on | `frame`, `heading`, `text`, `eyebrow`, `meta`, `buttons`, `height` (full/tall/short) | yes | no |
| Media Text | `zngiron/media-text` | A Frame beside a column of copy | `frame`, `heading`, `text`, `buttons`, `mediaSide` | yes | no |
| Card Grid | `zngiron/card-grid` | 2–4 equal-height Cards on a CSS grid | `columns` | yes | no |
| Card | `zngiron/card` | One card, child of Card Grid | `frame`, `title`, `text`, `url`, `linkText` | yes | no |
| Post Grid | `zngiron/post-grid` | Query over any post type, rendered as Cards | `postType`, `taxonomy`, `term`, `count`, `columns`, `orderBy`, `order`, `showFilters`, `filterTaxonomy` | yes | filter chips |
| Specs Table | `zngiron/specs-table` | Meta rows for the current post, from config | `heading`, `postId` | yes | no |
| Compare Table | `zngiron/compare-table` | 2–3 posts side by side over the same meta | `heading`, `postIds` | yes | no |
| Stats | `zngiron/stats` | Figures with labels | `heading`, `items[{value,label,prefix,suffix,plain}]` | yes | count-up |
| FAQ | `zngiron/faq` | `details` items plus FAQPage JSON-LD | `heading`, `items[{question,answer}]` | yes | no |
| Testimonials | `zngiron/testimonials` | Quotes, one at a time, no autoplay | `heading`, `items[{quote,name,role}]` | yes | prev/next |
| Locations | `zngiron/locations` | Address cards from config, tel and directions | `heading`, `slugs`, `showHours` | yes | no |
| Marquee | `zngiron/marquee` | CSS text loop, pauses on hover | `text`, `speed` | yes | no (CSS) |

## Where the data comes from

`config/brand.json` — post types, taxonomies and their terms, meta fields,
locations, social links. `Zngiron\Blocks\Config` reads it once and caches it;
the array is filterable through `zngiron_brand_config`. Specs Table, Compare
Table, Locations and the Product schema all read from there, so adding a meta
field to the JSON adds it to all of them.

## Shared pieces

- **Frame** (`src/components/Frame.js`, `src/frame.scss`, `Render::frame()`) —
  the sizing contract. Ratio from {21:9, 16:9, 3:2, 4:5, 1:1}, `cover` or
  `contain`, focal point via the core FocalPointPicker. Markup is
  `<figure class="z-frame" style="--z-ratio; --z-focal-x; --z-focal-y">`.
- **Buttons** and **Eyebrow** — the two other repeated shapes.
- `Render::card()` renders the Card for both the Card block and Post Grid.

Blocks use preset slots and `--z-*` custom properties with `--wp--preset--*`
fallbacks. No block contains a raw hex colour; palette, type and spacing are
theme.json presets and stay editable in Global Styles.

## Build

```
cd wp-content/plugins/zngiron-blocks && npm install && npm run build
```

`build/` is committed so deployment never needs Node.
