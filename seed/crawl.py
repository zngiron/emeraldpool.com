#!/usr/bin/env python3
"""
Crawl every internal link and image on the seeded demo and report anything broken.

    python3 seed/crawl.py [base-url]

Exit code 1 if any internal link 404s, any image fails to load, or any anchor is
a "#" placeholder. Used as the demo's link check; see docs/ARCHITECTURE.md.
"""
import re, sys, collections
from urllib.parse import urljoin, urlparse, urldefrag
from urllib.request import urlopen, Request
from urllib.error import HTTPError, URLError

BASE = (sys.argv[1] if len(sys.argv) > 1 else "http://localhost:8080").rstrip("/")
HOST = urlparse(BASE).netloc

def get(url, method="GET"):
    req = Request(url, method=method, headers={"User-Agent": "emerald-pool-link-check"})
    try:
        with urlopen(req, timeout=30) as r:
            return r.status, r.read() if method == "GET" else b""
    except HTTPError as e:
        return e.code, b""
    except URLError as e:
        return 0, str(e).encode()

ATTR = re.compile(rb'(?:href|src)\s*=\s*"([^"]*)"', re.I)
SRCSET = re.compile(rb'srcset\s*=\s*"([^"]*)"', re.I)

seen_pages, queue = set(), [BASE + "/"]
checked = {}                      # url -> status
placeholders = collections.defaultdict(list)   # page -> [raw href]
failures = collections.defaultdict(list)       # page -> [(url, status)]

def check(url, page):
    if url in checked:
        status = checked[url]
    else:
        status, _ = get(url, "GET")
        checked[url] = status
    if status >= 400 or status == 0:
        failures[page].append((url, status))
    return status

while queue:
    page = queue.pop(0)
    if page in seen_pages:
        continue
    seen_pages.add(page)
    status, body = get(page)
    checked[page] = status
    if status >= 400:
        failures["(entry)"].append((page, status))
        continue

    urls = [m.decode() for m in ATTR.findall(body)]
    for raw in SRCSET.findall(body):
        for part in raw.decode().split(","):
            u = part.strip().split(" ")[0]
            if u:
                urls.append(u)

    for raw in urls:
        raw = raw.strip()
        if not raw:
            continue
        if raw == "#" or raw.startswith("#!"):
            placeholders[page].append(raw)
            continue
        if raw.startswith(("mailto:", "tel:", "javascript:", "data:", "#")):
            continue
        absolute = urldefrag(urljoin(page, raw))[0]
        if urlparse(absolute).netloc != HOST:
            continue
        if "/wp-admin/" in absolute or "wp-login" in absolute:
            continue
        check(absolute, page)
        is_doc = not re.search(r"\.(jpg|jpeg|png|webp|gif|svg|ico|css|js|woff2?|xml|json)$", absolute, re.I)
        if is_doc and absolute not in seen_pages and absolute.startswith(BASE):
            queue.append(absolute)

print(f"crawled {len(seen_pages)} pages, {len(checked)} urls")
bad = sum(len(v) for v in failures.values())
ph = sum(len(v) for v in placeholders.values())
for page, items in sorted(failures.items()):
    print(f"\n  BROKEN on {page}")
    for url, status in sorted(set(items)):
        print(f"    {status}  {url}")
for page, items in sorted(placeholders.items()):
    print(f"\n  PLACEHOLDER href on {page}: {len(items)} x '#'")
print(f"\n{bad} broken, {ph} placeholder")
sys.exit(1 if (bad or ph) else 0)
