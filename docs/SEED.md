# Seed data

`make seed` turns a blank WordPress into the full Emerald Pool demo. It reads from
`seed/` and `research/assets/`, both committed, so a fresh clone has everything it
needs — there is no database dump to restore and no media to download.

Run it once after `make install`:

```sh
make seed
```

## What it creates

| | Count | Where it comes from |
|---|---|---|
| Attachments | 33 | `research/assets/`, mapped by `seed/media.txt` |
| Pages | 11 | `seed/content/*.html` |
| Journal posts | 3 | `seed/content/posts/*.html` |
| Spas | 10 | `seed/spas.json` |
| Spa types | 2 | Hot Tubs (7), Swim Spas (3) |
| Spa series | 6 | A Series, Calm, M Series, STIL, Swim Series, X Series |

The eleven pages are Home, Hot Tubs, Swim Spas, Services, Financing, About, Contact,
FAQ, Accessibility, Privacy and Journal. Navigation, the front page setting and the
permalink structure are set for you.

## The files

```
seed/
  seed.sh            what `make seed` runs, inside the wordpress:cli container
  media.txt          attachment key | file in research/assets | attachment title
  spas.json          the ten spa models and their spec meta
  content/*.html     block markup for each page
  content/posts/     block markup for the three journal posts
  php/content.php    creates the posts, pages, navigation and options
  crawl.py           `make crawl` — every internal link and image
  axe.py             `make axe`  — axe-core colour contrast
```

## It is safe to re-run

Seeding twice changes nothing but timestamps. Media is matched on a `_ep_seed_key`
meta value and every post on its slug, so a second run updates in place rather than
duplicating. Edit a page in the admin, run `make seed` again, and your edit is
replaced by the seeded version — that is the intent, it is how you get back to a
clean demo.

To start from an empty database instead:

```sh
make reset     # destroys the database volume, reinstalls WordPress
make seed
```

## The spa content model

Spas are a custom post type, not WooCommerce products — this is a marketing site, so
nothing is for sale. The post type, its two taxonomies and its eleven meta fields are
declared in `config/brand.json`, not in PHP:

| Field | Type | Specs table | Compare table |
|---|---|---|---|
| `spa_seats` | integer | ✓ | ✓ |
| `spa_lounge_seats` | integer | ✓ | |
| `spa_jets` | integer | ✓ | ✓ |
| `spa_pumps` | integer | ✓ | ✓ |
| `spa_capacity_gallons` | integer | ✓ | ✓ |
| `spa_dimensions` | string | ✓ | ✓ |
| `spa_dimensions_metric` | string | ✓ | |
| `spa_dry_weight` | integer | ✓ | |
| `spa_price_from` | number | ✓ | ✓ |
| `spa_brochure_url` | string | | |
| `spa_video_url` | string | | |

The **Specs Table** block builds its rows from every field flagged `specs`. The
**Compare Table** block builds its rows from every field flagged `compare`. Adding a
row to either is adding a field to `config/brand.json` — no block needs editing.

## Pointing it at another brand

The theme and the plugin name no client. To configure a second brand:

1. Edit `config/brand.json` — name, post types, taxonomies, meta fields, locations.
2. Replace the palette and type in `wp-content/themes/zngiron-base/theme.json`.
3. Replace the images in `research/assets/` and the map in `seed/media.txt`.
4. Replace the page markup in `seed/content/`.

`docs/ARCHITECTURE.md` covers this in full.

## Verifying a seeded site

```sh
make crawl     # every internal link and image, once — fails on a 404 or a "#" placeholder
make axe       # axe-core colour contrast, AA, 14 pages × 2 widths × 2 scroll positions
make shots     # viewport screenshots at six widths, with layout assertions
```

`make crawl` and `make axe` need Python on the host; `make shots` needs Node and
Playwright. None of them are needed to run the demo.
