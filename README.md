# Emerald Pool — Gutenberg block theme demo

A WordPress block theme (FSE) + custom blocks demo, modelled on
[emeraldpool.com](https://emeraldpool.com). Marketing pages only — **no WooCommerce**.
Products are a `spa` custom post type.

See `docs/PLAN.md` for the build plan and `docs/IA-UX-AUDIT.md` for the audit that drives the rebuild.

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
| `make install` | Core install + activate `emerald-pool` theme and `emerald-pool-blocks` plugin + `/%postname%/` permalinks |
| `make seed` | Run `seed/seed.sh` inside the `cli` container |
| `make reset` | Destroy volumes, recreate, reinstall |

## Layout

```
docker-compose.yml        wordpress:latest · mariadb:11 · wordpress:cli
Makefile
.env / .env.example       credentials, port, admin user
wp-content/themes/        bind-mounted into the container (block theme goes here)
wp-content/plugins/       bind-mounted into the container (custom blocks plugin goes here)
seed/
  seed.sh                 orchestration: media import, permalinks (runs in the cli container)
  spas.json               the ten spa models and their spec meta
  media.txt               attachment key -> file in research/assets
  content/*.html          block markup for each page and journal post
  php/content.php         creates the posts, pages, menu and options (idempotent)
research/                 scraped source material
  pages/*.md                per-page copy, headings, CTAs, images
  site.json                 nav, footer, contact, page index, taxonomies
  spa-specs.json            spec tables for 7 representative models
  design-tokens.md          observed colours, fonts, spacing
  assets/                   22 downloaded images + manifest.json
docs/
  PLAN.md                 the build plan
  IA-UX-AUDIT.md          audit of the live site + the IA this rebuild implements
  ARCHITECTURE.md         how the theme and plugin are put together
  BLOCKS.md               the nine custom blocks
  CTO-SUMMARY.md          what was delivered, and what production would need
  screenshots/            mobile and desktop captures of the seeded site
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
  `cd wp-content/plugins/emerald-pool-blocks && npm install && npm run build`. `build/` is committed.
