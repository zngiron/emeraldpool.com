SHELL := /bin/bash
include .env
export

.PHONY: up down logs wp install seed reset shots crawl axe deck

up:
	docker compose up -d
	@echo "WordPress: $(WP_URL)"

down:
	docker compose down

logs:
	docker compose logs -f --tail=100

# usage: make wp ARGS="plugin list"
wp:
	docker compose run --rm cli $(ARGS)

install:
	docker compose run --rm cli core install \
		--url=$(WP_URL) --title="$(WP_TITLE)" \
		--admin_user=$(WP_ADMIN_USER) --admin_password=$(WP_ADMIN_PASS) \
		--admin_email=$(WP_ADMIN_EMAIL) --skip-email || true
	docker compose run --rm cli plugin activate zngiron-blocks
	docker compose run --rm cli theme activate zngiron-base
	docker compose run --rm cli rewrite structure "/%postname%/" --hard
	docker compose run --rm cli rewrite flush --hard
	@echo "Installed: $(WP_URL)  admin: $(WP_ADMIN_USER)/$(WP_ADMIN_PASS)"

seed:
	docker compose run --rm --entrypoint /bin/sh cli /seed/seed.sh

reset:
	docker compose down -v
	docker compose up -d
	@sleep 10
	$(MAKE) install

# Viewport screenshots plus the layout assertions, at six widths.
# Shots land in .shots/ (ignored); docs/screenshots/ is a curated selection.
# usage: make shots ARGS="--widths=390,1440 --pages=home"
OUT ?= .shots
shots:
	node tools/screenshot.js $(OUT) $(ARGS)

# Every internal link and image, once.
crawl:
	python3 seed/crawl.py $(WP_URL)

# axe-core colour contrast, AA.
axe:
	python3 seed/axe.py $(WP_URL)

# The handover deck, from docs/screenshots into docs/*.pdf.
deck:
	sh tools/deck/build.sh
