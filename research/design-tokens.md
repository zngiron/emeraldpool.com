# Observed design tokens — emeraldpool.com

Source: single SiteGround-combined stylesheet
`/wp-content/uploads/siteground-optimizer-assets/siteground-optimizer-combined-css-*.css` (~610 KB).
Tokens live as CSS custom properties defined by the `spa-software-solutions` vendor plugin
(`--sss-*`) plus a per-client override layer (`--emerald-pool-and-patio-*`).

## Brand palette (client override layer)

| Token | Hex | Notes |
|---|---|---|
| `--emerald-pool-and-patio-blue` | `#1a68ae` | Primary brand blue. Logo, primary buttons, links. |
| `--emerald-pool-and-patio-light-blue` | `#cbdded` | Tint / section background. RGB var says `75,197,225` (`#4bc5e1`) — the hex and the rgb triplet disagree. |
| `--emerald-pool-and-patio-gray` | `#333333` | Body / accent, also used as "accent color". |
| `--emerald-pool-and-patio-dark-gray` | `#262626` | Footer, dark sections. |
| `--emerald-pool-and-patio-black` | `#202020` | Headings on dark. |
| `--emerald-pool-and-patio-white` | `#ffffff` | Surfaces. |

## Vendor defaults still shipping (not overridden, but present in the bundle)

| Token | Hex |
|---|---|
| `--sss-accent-color-hex` | `#c39d63` (gold — vendor default, overridden to gray) |
| `--sss-body-color-hex` | `#5c5c5c` |
| `--sss-primary-font-color-hex` | `#404040` |
| `--sss-primary-title-color-hex` | `#5c5c5c` |
| `--sss-primary-btn-text-color-hex` | `#fff` |
| `--sss-accent-button-radius` | `20px` |

## Bootstrap 4 defaults also in the bundle (dead weight)

`--primary:#007bff`, `--secondary:#6c757d`, `#dc3545`, `#28a745`, `#ffc107`, `#17a2b8`,
`#212529`, `#343a40`, `#f8f9fa`, `#dee2e6`, `#e9ecef`, `#495057`.
These are the untouched Bootstrap palette — ~39 occurrences of `#007bff` alone, none of which is
the brand blue. Three colour systems coexist: Bootstrap, `--sss-*`, `--emerald-pool-and-patio-*`.

## Typography

| Role | Stack |
|---|---|
| `--sss-title-font` | `"Crimson Pro", serif` (client), vendor fallback `Georgia, "Times New Roman", serif` |
| `--sss-secondary-title-font` | `"Roboto", Arial, sans-serif` |
| `--sss-paragraph-font` | `"Roboto", Helvetica, Arial, Lucida, sans-serif` |
| `--sss-primary-btn-font` | `"Roboto", Helvetica, Arial, Lucida, sans-serif` |
| strays | `georgiapro`, `noto sans !important`, `WooCommerce` icon font, `Font Awesome 5 Free`, `slick` |

Loading: Google Fonts (`fonts.googleapis.com` + `fonts.gstatic.com`) with `preconnect` and
`preload` of raw `.ttf` files (not `woff2`) — Roboto v30 `KFOmCnqEu92Fr1Mu4mxP.ttf` etc.
Four icon/utility font families load on every page.

## Spacing / radius / layout

- No spacing scale token exists. Margins and paddings are hardcoded per component, plus 83
  inline `style="..."` attributes on the homepage alone.
- Container: Bootstrap 4 grid, max `1240px`, `20px` side gutter (visible in the host 403 page too).
- Radius: `--sss-accent-button-radius: 20px` (pill buttons); everything else ad hoc.
- Breakpoints: Bootstrap 4 (`576/768/992/1200`) plus a custom `navbar-expand-xl` for the mega menu.
- Core WP preset tokens (`--wp--preset--dimension--25/50/100`) are emitted but the theme does not
  use them — the theme is classic PHP, not a block theme.

## Recommendation for the rebuild (`theme.json`)

```
Palette   brand-blue   #1a68ae   (primary)
          brand-deep   #0f4472   (darker blue for hover / dark sections — derived)
          brand-mist   #cbdded   (tint surface)
          brand-aqua   #4bc5e1   (accent — resolve the light-blue conflict in favour of this)
          ink          #202020
          slate        #5c5c5c   (body text)
          line         #e4e4e4
          surface      #f8f9fa
          white        #ffffff
Fonts     Display: Crimson Pro (serif)  •  Body/UI: Roboto (sans)   — self-hosted woff2
Spacing   20 / 30 / 40 / 60 / 80 / 120  (theme.json spacingScale, 6 steps)
Radius    4px controls, 20px pill CTAs, 12px cards
Layout    contentSize 780px, wideSize 1240px
```
