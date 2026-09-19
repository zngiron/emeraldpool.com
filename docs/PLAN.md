# Emerald Pool — Gutenberg block theme demo

Goal: show CTO what we can do with custom WordPress block themes + Gutenberg blocks.
Source site: https://emeraldpool.com (WordPress 7.1.1, WooCommerce 11.1.1, theme `wordpress-spa-logic-hot-tubs-theme`).
Business: Emerald Pool — hot tubs / swim spas / pool retailer.

## Decisions (from user)
- Block theme (FSE): theme.json tokens, HTML templates, patterns, 5-8 custom blocks via @wordpress/scripts.
- No WooCommerce. Marketing pages only. Products modelled as a `spa` custom post type (hot tubs, swim spas) with taxonomies.
- Reuse live-site assets: scrape logo, hero/product images, copy from emeraldpool.com.
- Local env: OrbStack/Docker compose (wordpress + mariadb + wpcli). No PHP/wp on host.
- Lean budget: 3 sequential agents. Do not over-research.
- Git: branch `development`. Conventional Commits. NO Co-Authored-By / generated-with trailers. Never push.

## Layout
- `docker-compose.yml`, `.env.example`, `Makefile` (up/down/seed/build)
- `research/` scraped copy (json/md) + `research/assets/` images
- `wp-content/themes/emerald-pool/` block theme
- `wp-content/plugins/emerald-pool-blocks/` custom blocks + `spa` CPT
- `seed/` wp-cli seed script
- `docs/` IA audit, CTO summary

## Phases
1. Research + env (agent 1): scrape, IA/UX audit, docker env running at http://emeraldpool.local or localhost:8080.
2. Theme + blocks (agent 2).
3. Seed + verify + CTO summary (agent 3).
