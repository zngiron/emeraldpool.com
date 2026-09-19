#!/bin/sh
# Seed script for the Emerald Pool demo. Runs inside the wordpress:cli container.
# Phase 3 fills this in: spa CPT entries, pages, menus, media sideload from /research/assets.
set -e

echo "==> Emerald Pool seed (stub)"
wp --info >/dev/null
echo "    WordPress: $(wp option get home)"
echo "    Nothing to seed yet — phase 3 populates content here."
