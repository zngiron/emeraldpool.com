#!/bin/sh
# Build the handover deck: docs/screenshots -> scaled JPEGs -> a 16:9 PDF.
#
# The slides reference JPEGs rather than the curated PNGs because Chromium
# embeds images at their source size: the PNGs make a 12 MB PDF nobody wants
# to email, and at slide scale the difference is invisible.
#
#   sh tools/deck/build.sh          (or: make deck)
#
# Needs Node with Playwright, and sips (macOS). Regenerate the captures first
# with `make shots` if the site has changed.
set -eu

HERE=$(cd "$(dirname "$0")" && pwd)
ROOT=$(cd "${HERE}/../.." && pwd)
SHOTS="${ROOT}/docs/screenshots"
OUT="${HERE}/shots"

PAGES="home hot-tubs spa-single services journal contact"

mkdir -p "${OUT}"

for PAGE in ${PAGES}; do
	for PAIR in "1440 desktop 1100 72" "390 mobile 400 76"; do
		# shellcheck disable=SC2086
		set -- ${PAIR}
		SRC="${SHOTS}/${PAGE}-$1-top.png"

		if [ ! -f "${SRC}" ]; then
			echo "!! missing ${SRC} — run 'make shots' first" >&2
			exit 1
		fi

		sips -s format jpeg -s formatOptions "$4" --resampleWidth "$3" \
			"${SRC}" --out "${OUT}/${PAGE}-$2.jpg" >/dev/null
	done
done

echo "scaled $(ls "${OUT}" | wc -l | tr -d ' ') captures"

node "${HERE}/topdf.js"
