# Colour contrast — WCAG 2.2 AA

Audit and remediation of every text/background and non-text pairing the site
actually renders. Ratios are computed with the WCAG 2.x relative-luminance
formula; translucent foregrounds are flattened onto their ground first.

Thresholds applied:

| Content | Required |
|---|---|
| Body text (< 18.66px bold / < 24px) | 4.5:1 |
| Large text (≥ 24px, or ≥ 18.66px bold) | 3:1 |
| UI components and state/focus indicators (SC 1.4.11) | 3:1 |

Method: palette extracted from `wp-content/themes/emerald-pool/theme.json`,
every pairing that the theme and plugin stylesheets can actually produce
enumerated by hand, then axe-core 4.10.2 run through Playwright on home,
hot tubs, a single spa, FAQ and contact at 1440 and 390.

---

## 1. The root cause

The night ground was already sound: `sand` on `abyss` is 14.53:1 and the
`ember` accent is 7.02:1 there. The failures were all on the **light** ground.
`ember` (`#e08a3c`) is a mid-tone orange picked to glow on water-black; on
white it is 2.66:1, which clears neither 4.5:1 nor even the 3:1 large-text
floor. Every light-section price, figure, hover colour and focus ring
inherited that one value.

`text-muted` (`#546c78`) was a second, quieter failure: fine on white (5.54:1)
but 4.30:1 on the `sand` paper field.

**14 distinct pairings failed.**

## 2. The fix, at token level

Ember is now one hue in three tones, declared in `theme.json`:

| Token | Value | Purpose |
|---|---|---|
| `ember` | `#e08a3c` | unchanged — the night-ground accent, and the button fill |
| `ember-strong` | `#b7651a` | large display text, rules and focus indicators on a light ground |
| `ember-deep` | `#93541a` | small copy, prices and links on a light ground |

`text-muted` moved from `#546c78` to `#4c616c` (same hue and saturation, HSL
lightness 40% → 36%), which clears 4.5:1 on all four light grounds.

Blocks never reference those three tokens directly. `assets/css/theme.css`
declares two ground-aware variables that resolve differently on each ground,
so a block written once is correct in both places:

```css
:root {
	--ep-ember-text: var(--wp--preset--color--ember-deep);   /* 4.5:1 tone */
	--ep-ember-mark: var(--wp--preset--color--ember-strong); /* 3:1 tone   */
}

.ep-night, .ep-hero, .ep-spa-hero,
.has-deep-background-color,
.has-abyss-background-color,
.has-primary-dark-background-color {
	--ep-ember-text: var(--wp--preset--color--ember);
	--ep-ember-mark: var(--wp--preset--color--ember);
}
```

No per-block hex value was introduced; the only per-block change is swapping
`var(--wp--preset--color--ember)` for whichever of the two variables applies.

## 3. Pairs fixed

| Pair | Ground | Need | Before | After | Set in |
|---|---|---|---|---|---|
| Card price `strong` (12px) | base | 4.5:1 | 2.67 ✗ | **5.96** ✓ | `plugins/emerald-pool-blocks/assets/shared.css` `.ep-card__price strong` |
| Card title, hover/focus-within | base | 4.5:1 | 2.67 ✗ | **5.96** ✓ | `plugins/emerald-pool-blocks/assets/shared.css` `.ep-card:hover .ep-card__title` |
| Grid filter, hover (12px) | base | 4.5:1 | 2.67 ✗ | **5.96** ✓ | `plugins/.../src/blocks/spa-grid/style.scss` `.ep-grid__filter:hover` |
| Series index `h4` link, hover (19px) | base | 4.5:1 | 2.67 ✗ | **5.96** ✓ | `themes/emerald-pool/assets/css/theme.css` `.ep-series-index h4 a:hover` |
| Muted text | sand | 4.5:1 | 4.30 ✗ | **5.04** ✓ | `theme.json` `text-muted` |
| Muted text | surface-alt | 4.5:1 | 4.70 | **5.52** | `theme.json` `text-muted` |
| Muted text | surface | 4.5:1 | 5.18 | **6.08** | `theme.json` `text-muted` |
| Muted text | base | 4.5:1 | 5.54 | **6.49** | `theme.json` `text-muted` |
| Quick-fact figures (24.7 / 36px) | base | 3:1 | 2.67 ✗ | **4.29** ✓ | `theme.css` `.ep-spa-quickfacts p:not(.is-style-eyebrow)` |
| Stats figures (large display) | base | 3:1 | 2.67 ✗ | **4.29** ✓ | `plugins/.../src/blocks/spa-stats/style.scss` `&__figure` |
| Solid section numeral (large display) | base | 3:1 | 2.67 ✗ | **4.29** ✓ | `theme.css` `.ep-numeral--solid` |
| Journal card title, hover (≥ 24px) | base | 3:1 | 2.67 ✗ | **4.29** ✓ | `theme.css` `.ep-journal .wp-block-post:hover .wp-block-post-title a` |
| Focus ring (3px outline) | base | 3:1 | 2.67 ✗ | **4.29** ✓ | `theme.css` `:focus-visible` |
| Focus ring (3px outline) | surface | 3:1 | 2.50 ✗ | **4.02** ✓ | `theme.css` `:focus-visible` |
| Focus ring (3px outline) | sand | 3:1 | 2.07 ✗ | **3.33** ✓ | `theme.css` `:focus-visible` |
| Form field focus underline | base | 3:1 | 2.67 ✗ | **4.29** ✓ | `theme.css` `.ep-form input:focus` |
| Active filter rule (2px, state indicator) | base | 3:1 | 2.67 ✗ | **4.29** ✓ | `plugins/.../src/blocks/spa-grid/style.scss` `[aria-pressed="true"]::before` |

## 4. Pairs audited and already passing — unchanged

All set in `theme.json` unless noted; night-ground opacities are in
`themes/emerald-pool/assets/css/theme.css` and the block stylesheets.

| Pair | Need | Ratio |
|---|---|---|
| Body `ink` on base | 4.5:1 | 15.96 |
| Headings `primary-dark` on base | 4.5:1 | 12.79 |
| Link `primary` on base | 4.5:1 | 8.15 |
| Form label `primary-dark` on base | 4.5:1 | 12.79 |
| Icon badge `primary` on surface-alt | 4.5:1 | 6.93 |
| `sand` on abyss | 4.5:1 | 14.53 |
| `sand` on deep | 4.5:1 | 12.33 |
| Night paragraph `sand @ 74%` on abyss | 4.5:1 | 8.26 |
| Night paragraph `sand @ 74%` on deep | 4.5:1 | 7.33 |
| Hero standfirst `sand @ 82%` on abyss | 4.5:1 | 9.95 |
| Hero meta `sand @ 72%` on abyss | 4.5:1 | 7.87 |
| Card meta `sand @ 60%` on abyss | 4.5:1 | 5.77 |
| Marquee `sand @ 62%` on deep | 4.5:1 | 5.56 |
| Night feature text `white @ 78%` on deep | 4.5:1 | 10.10 |
| Store label `white @ 95%` on deep | 4.5:1 | 14.43 |
| Store address `white @ 76%` on deep | 4.5:1 | 9.65 |
| Eyebrow `ember` on abyss | 4.5:1 | 7.02 |
| Eyebrow `ember` on deep | 4.5:1 | 5.96 |
| Eyebrow `ember` on primary-dark | 4.5:1 | 4.79 |
| Footer statement `em` `ember` on abyss | 3:1 | 7.02 |
| `accent` link on deep | 4.5:1 | 7.85 |
| `accent` link on primary-dark | 4.5:1 | 6.32 |
| Button `base` on primary-dark | 4.5:1 | 12.79 |
| Button hover `abyss` on ember | 4.5:1 | 7.02 |
| Outline-quiet button `sand` on abyss | 4.5:1 | 14.53 |
| Outline-quiet stroke `sand @ 40%` on abyss | 3:1 | 3.21 |
| Focus ring `ember` on abyss | 3:1 | 7.02 |
| Focus ring `ember` on deep | 3:1 | 5.96 |

`accent` (`#4bc5e1`) is only ever applied on `deep` or `primary-dark` grounds,
so its 2.02:1 against white never occurs and the token is left alone.

## 5. Documented exemptions

- **Ghost section numerals** — `.ep-numeral` (`01`, `02`, …) renders as
  transparent display type with a 1px `border` stroke, 1.34:1 on white. These
  are decorative chapter ordinals: they label nothing, carry no information
  not already in the adjacent heading, and are exempt as pure decoration
  (SC 1.4.3). Giving them a 3:1 stroke would turn a ghost into a headline.
  `.ep-numeral--solid`, which *is* read as a figure, was fixed above.
- **Hairline rules** — `border` on base (1.34:1) and `sand @ 18%` on abyss
  (1.57:1) are separators, not UI components, and are outside SC 1.4.11.
- **Text over photography** — the transparent header state and the hero sit on
  images behind a `scrim` gradient (`rgba(4,20,27,.86)` at the foot). axe
  cannot compute these; the scrim is the mitigation and is unchanged.

## 6. axe-core result

axe-core 4.10.2, rule `color-contrast`, via Playwright/Chromium, on
`/`, `/hot-tubs/`, `/spas/bullfrog-a7d/`, `/faq/`, `/contact/` at 1440×900 and
390×844 (10 runs):

| | violations |
|---|---|
| Before | 10 nodes — all `#e08a3c` on `#ffffff` at 2.66:1 (card prices at 4.5:1, quick-fact figures at 3:1), single spa page, both viewports |
| After | **0** |

`color-contrast-enhanced` (AAA, 7:1) reports 118 nodes and is out of scope for
AA; hover, focus and `[aria-pressed]` states are unreachable by an axe scan and
were verified by computation in §3.
