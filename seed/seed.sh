#!/bin/sh
# Emerald Pool demo seed. Runs inside the wordpress:cli container (see `make seed`).
#
#   /research  research/  (scraped copy and images)
#   /seed      seed/      (this script, spas.json, media.txt, content/)
#
# Idempotent: media is matched on a _ep_seed_key meta value, every post is matched on
# its slug and updated in place. Running it twice changes nothing but timestamps.
set -eu

MEDIA_MAP=/tmp/ep-media.txt

echo "==> Emerald Pool seed"
echo "    site: $(wp option get home)"

# ---------------------------------------------------------------- 1. remove the test spa.
for CANDIDATE in 5 $(wp post list --post_type=spa --post_status=any --field=ID || true); do
	if [ "$(wp post get "${CANDIDATE}" --field=post_title 2>/dev/null || true)" = "Model X7" ] \
		&& [ "$(wp post get "${CANDIDATE}" --field=post_type 2>/dev/null || true)" = "spa" ]; then
		wp post delete "${CANDIDATE}" --force >/dev/null
		echo "    deleted placeholder spa #${CANDIDATE} (Model X7)"
	fi
done

# ---------------------------------------------------------------- 2. media.
echo "==> Media"
: >"${MEDIA_MAP}"

while IFS='|' read -r KEY FILE TITLE; do
	case "${KEY}" in ''|\#*) continue ;; esac

	ID=$(wp post list --post_type=attachment --post_status=any \
		--meta_key=_ep_seed_key --meta_value="${KEY}" \
		--field=ID --posts_per_page=1 | head -n1 || true)

	if [ -z "${ID}" ]; then
		if [ ! -f "/research/assets/${FILE}" ]; then
			echo "    !! missing /research/assets/${FILE}" >&2
			continue
		fi
		ID=$(wp media import "/research/assets/${FILE}" --title="${TITLE}" --porcelain)
		wp post meta update "${ID}" _ep_seed_key "${KEY}" >/dev/null
		wp post meta update "${ID}" _wp_attachment_image_alt "${TITLE}" >/dev/null
		echo "    imported ${KEY} -> #${ID}"
	fi

	echo "${KEY}=${ID}" >>"${MEDIA_MAP}"
done <"/seed/media.txt"

echo "    $(wc -l <"${MEDIA_MAP}" | tr -d ' ') attachments available"

# ---------------------------------------------------------------- 3. content.
# `wp eval-file` silently swallows this script in wordpress:cli; `wp eval` + require does not.
wp eval 'require "/seed/php/content.php";'

# ---------------------------------------------------------------- 4. permalinks.
echo "==> Permalinks"
wp rewrite structure '/%postname%/' --hard >/dev/null
wp rewrite flush --hard >/dev/null
wp cache flush >/dev/null 2>&1 || true

echo "==> Done"
wp post list --post_type=spa --format=count --post_status=publish | sed 's/^/    spas: /'
wp post list --post_type=page --format=count --post_status=publish | sed 's/^/    pages: /'
wp post list --post_type=post --format=count --post_status=publish | sed 's/^/    posts: /'
