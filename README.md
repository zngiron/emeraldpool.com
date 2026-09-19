# Emerald Pool — Gutenberg block theme demo

A WordPress block theme (FSE) + custom blocks demo, modelled on
[emeraldpool.com](https://emeraldpool.com). Marketing pages only — **no WooCommerce**.
Products are a `spa` custom post type.

The site is a base theme (`zngiron-base`) plus a blocks plugin (`zngiron-blocks`) under one
namespace, with a strict sizing contract so another brand's photographs and copy drop in
without per-image tuning. Emerald Pool is the first brand configured on it.

Start at `docs/CTO-SUMMARY.md`. `docs/ARCHITECTURE.md` is how it fits together, `docs/BLOCKS.md`
is the blocks, `docs/IA-UX-AUDIT.md` is the audit and the IA that shipped, and
`docs/superpowers/specs/` is the design the build follows.

## Requirements

- OrbStack (or Docker Desktop) running
- `make`

No PHP, MySQL or wp-cli on the host — everything runs in containers.

## Run it

```sh
cp .env.example .env     # first time only
make up                  # start wordpress + mariadb
make install             # wp core install, activate theme/plugin, set permalinks
make seed                # import media, spas, pages, menu — idempotent
```

Then open **http://localhost:8080**.

To check it afterwards — all three run on the host, against the running site:

```sh
make shots               # viewport screenshots at six widths, with assertions
make crawl               # every internal link and image, once
make axe                 # axe-core colour contrast, AA
```

| | |
|---|---|
| Site | http://localhost:8080 |
| Admin | http://localhost:8080/wp-admin |
| User | `admin` |
| Password | `admin` |
| Email | `admin@emeraldpool.local` |

## Make targets

| Target | Does |
|---|---|
| `make up` | `docker compose up -d` |
| `make down` | Stop containers (volumes kept) |
| `make logs` | Tail all container logs |
| `make wp ARGS="plugin list"` | Run any wp-cli command in the `cli` container |
| `make install` | Core install + activate `zngiron-base` theme and `zngiron-blocks` plugin + `/%postname%/` permalinks |
| `make seed` | Run `seed/seed.sh` inside the `cli` container |
| `make reset` | Destroy volumes, recreate, reinstall |
| `make shots` | Screenshots + layout assertions into `.shots/`; `ARGS="--widths=390 --pages=home"` narrows it |
| `make crawl` | Crawl every internal link and image; non-zero exit on a 404 or a `#` placeholder |
| `make axe` | axe-core `color-contrast` over every page, two widths, two scroll positions |

## Layout

```
docker-compose.yml        wordpress:latest · mariadb:11 · wordpress:cli
Makefile
.env / .env.example       credentials, port, admin user
config/brand.json         the brand: name, post types, meta fields, locations, social
wp-content/themes/zngiron-base/    the base theme (bind-mounted)
wp-content/plugins/zngiron-blocks/ the twelve blocks (bind-mounted, build/ committed)
tools/screenshot.js       viewport screenshots and the layout assertions
seed/
  seed.sh                 orchestration: media import, permalinks (runs in the cli container)
  spas.json               the ten spa models and their spec meta
  media.txt               attachment key -> file in research/assets
  content/*.html          block markup for each page and journal post
  php/content.php         creates the posts, pages, menu and options (idempotent)
  crawl.py                `make crawl`: every internal link and image
  axe.py                  `make axe`: axe-core colour contrast
research/                 scraped source material
  pages/*.md                per-page copy, headings, CTAs, images
  site.json                 nav, footer, contact, page index, taxonomies
  spa-specs.json            spec tables for 7 representative models
  design-tokens.md          observed colours, fonts, spacing
  assets/                   33 downloaded images + manifest.json
docs/
  CTO-SUMMARY.md          what was delivered, and what production would need — start here
  ARCHITECTURE.md         the folder map, the sizing contract, and how to rebrand
  BLOCKS.md               the twelve custom blocks
  IA-UX-AUDIT.md          audit of the live site + the IA that shipped
  screenshots/            twenty curated captures of the seeded site
  superpowers/specs/      the approved design this build follows
```

Only `wp-content/themes` and `wp-content/plugins` are bind-mounted; WordPress core and
`wp-content/uploads` live in named volumes, so `make reset` gives a clean site without
touching the code you are working on.

## Notes

- `.env` is gitignored; `.env.example` is committed.
- `wp-content/uploads` is gitignored — media is re-created by `make seed`.
- The `cli` service runs as uid 33 (`www-data`) so files it writes are owned correctly.
- `make seed` is safe to re-run: media is matched on a meta key and every post on its slug,
  so a second run updates in place rather than duplicating.
- Rebuilding the blocks needs Node only if you change `src/`:
  `cd wp-content/plugins/zngiron-blocks && npm install && npm run build`. `build/` is committed.
- `make shots` needs Node and a Playwright install on the host; `make crawl` and `make axe` need
  Python. Nothing else on the host needs PHP or MySQL.
