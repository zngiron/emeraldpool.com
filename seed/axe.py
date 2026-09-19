#!/usr/bin/env python3
"""
axe-core colour-contrast audit across the seeded demo, at 1440 and 390.

    python3 seed/axe.py [base-url]

Exit code 1 on any violation. See docs/A11Y-CONTRAST.md.
"""
import sys, json, urllib.request
from playwright.sync_api import sync_playwright

BASE = (sys.argv[1] if len(sys.argv) > 1 else "http://localhost:8080").rstrip("/")
AXE = "https://cdnjs.cloudflare.com/ajax/libs/axe-core/4.10.2/axe.min.js"
PATHS = ["/", "/hot-tubs/", "/spas/bullfrog-a7d/", "/contact/", "/spa-type/hot-tubs/",
         "/about/", "/faq/", "/journal/", "/financing/", "/services/", "/swim-spas/",
         "/accessibility/", "/privacy/", "/spas/"]

# Every page is measured twice: at the top, where the header may be transparent
# over a hero, and scrolled, where it is the solid pinned state. They are two
# different sets of colours and both have to clear AA.
SCROLLS = [0, 1200]

src = urllib.request.urlopen(AXE, timeout=60).read().decode()
total = 0
with sync_playwright() as p:
    b = p.chromium.launch()
    for label, w, h in (("desktop", 1440, 900), ("mobile", 390, 844)):
        ctx = b.new_context(viewport={"width": w, "height": h})
        pg = ctx.new_page()
        for path in PATHS:
          pg.goto(BASE + path, wait_until="networkidle")
          for y in SCROLLS:
            pg.evaluate(f"window.scrollTo(0, {y})")
            pg.wait_for_timeout(600)
            pg.evaluate("""async () => {
              document.querySelectorAll('img[loading="lazy"]').forEach(i => i.loading = 'eager');
              await Promise.all([...document.images].filter(i => !i.complete).map(i => i.decode().catch(() => {})));
              if (document.fonts) await document.fonts.ready;
            }""")
            pg.add_script_tag(content=src)
            # AA only: `color-contrast-enhanced` is the AAA 7:1 rule and is not the bar here.
            res = pg.evaluate("axe.run(document, {runOnly:{type:'rule',values:['color-contrast']}})")
            for v in res["violations"]:
                total += len(v["nodes"])
                print(f"\n  {label} {path} @{y}  {v['id']}  ({len(v['nodes'])})")
                for n in v["nodes"][:8]:
                    print("    ", n["target"], "|", n["any"][0]["message"].replace("\n", " ") if n["any"] else "")
        ctx.close()
    b.close()
print(f"\n{total} colour-contrast violations across {len(PATHS)} pages x 2 widths x {len(SCROLLS)} scroll positions")
sys.exit(1 if total else 0)
