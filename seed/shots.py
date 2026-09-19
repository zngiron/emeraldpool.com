#!/usr/bin/env python3
"""
Full-page screenshots of the seeded demo, at 1440 and 390, into docs/screenshots.

    python3 seed/shots.py [base-url] [out-dir]

Chromium's one-shot `full_page` capture silently drops absolutely-positioned
images inside clipped containers once a page is a few thousand pixels tall — the
series chapters and the editorial bands come out as empty colour fields. Every
page is therefore captured by scrolling a viewport down it and stitching the
frames. Fixed and sticky elements are pinned for the same reason: otherwise the
header prints once per frame.

Needs `pip install playwright pillow` and `playwright install chromium`.
"""
import io
import os
import sys

from PIL import Image
from playwright.sync_api import sync_playwright

BASE = (sys.argv[1] if len(sys.argv) > 1 else "http://localhost:8080").rstrip("/")
OUT = sys.argv[2] if len(sys.argv) > 2 else "docs/screenshots"

PAGES = [
    ("home", "/"),
    ("hot-tubs", "/spa-type/hot-tubs/"),
    ("spa-single", "/spas/bullfrog-a7d/"),
    ("about", "/about/"),
    ("contact", "/contact/"),
    ("faq", "/faq/"),
    ("journal", "/journal/"),
]

# Lazy images are eager for the capture, and the fonts have to have landed or the
# type reflows between one stitched frame and the next.
SETTLE = """async () => {
  document.querySelectorAll('img[loading="lazy"]').forEach(i => { i.loading = 'eager'; });
  await new Promise(r => requestAnimationFrame(() => requestAnimationFrame(r)));
  await Promise.all([...document.images].filter(i => !i.complete).map(i => i.decode().catch(() => {})));
  if (document.fonts) await document.fonts.ready;
}"""

PIN = """() => {
  const header = document.querySelector('.ep-site-header');
  if (header) { header.style.position = 'absolute'; header.style.top = '0'; }
  document.querySelectorAll('.ep-stats__head, .ep-spa-rail__inner').forEach(e => { e.style.position = 'static'; });
  document.documentElement.style.scrollBehavior = 'auto';
}"""


def capture(page, path, width, height):
    page.evaluate(SETTLE)
    page.evaluate(PIN)
    page.wait_for_timeout(400)
    total = page.evaluate("document.documentElement.scrollHeight")
    frames, y = [], 0
    while y < total:
        page.evaluate(f"window.scrollTo(0, {y})")
        page.wait_for_timeout(260)
        top = page.evaluate("window.scrollY")
        frames.append((top, Image.open(io.BytesIO(page.screenshot()))))
        if top + height >= total:
            break
        y = top + height
    sheet = Image.new("RGB", (width, total), "white")
    for top, frame in frames:
        sheet.paste(frame, (0, top))
    sheet.save(path)
    return total


def main():
    os.makedirs(OUT, exist_ok=True)
    with sync_playwright() as playwright:
        browser = playwright.chromium.launch()
        for label, width, height in (("desktop", 1440, 900), ("mobile", 390, 844)):
            # Reduced motion so the scroll-driven reveals are settled, not mid-flight.
            context = browser.new_context(
                viewport={"width": width, "height": height},
                device_scale_factor=1,
                reduced_motion="reduce",
            )
            page = context.new_page()
            for name, path in PAGES:
                page.goto(BASE + path, wait_until="networkidle")
                capture(page, f"{OUT}/{name}-{label}.png", width, height)
                print(f"  {name}-{label}.png")

            if label == "desktop":
                # The grid filter is the one interaction worth a still of its own.
                page.goto(BASE + "/spa-type/hot-tubs/", wait_until="networkidle")
                page.click('.ep-filter[data-series="x-series"]')
                page.wait_for_timeout(600)
                capture(page, f"{OUT}/hot-tubs-filtered-desktop.png", width, height)
                print("  hot-tubs-filtered-desktop.png")
            else:
                page.goto(BASE + "/", wait_until="networkidle")
                page.click(".wp-block-navigation__responsive-container-open")
                page.wait_for_timeout(600)
                page.screenshot(path=f"{OUT}/home-mobile-nav-open.png")
                print("  home-mobile-nav-open.png")

            context.close()
        browser.close()


if __name__ == "__main__":
    main()
