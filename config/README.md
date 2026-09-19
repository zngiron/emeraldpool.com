# config/

`brand.json` is the one place the site's client-specific data lives. The
`zngiron-blocks` plugin reads it once per request through `Zngiron\Blocks\Config`
and caches it; the whole array is filterable via `zngiron_brand_config`.

## Shape

```
brand      { name, shortName, tagline }
postTypes  { <slug>: {
             singular, plural, description, slug, restBase, menuIcon,
             supports  [ string ],
             taxonomies { <tax slug>: { singular, plural, slug, hierarchical, terms { <slug>: label } } },
             meta [ { key, label, type, unit, specs, compare } ]
           } }
locations  [ { slug, name, legal, street, city, region, postcode, country, phone, hours, map, note } ]
social     [ { label, url } ]
```

### Meta fields

- `type` — `string`, `integer` or `number`. Drives the `register_post_meta`
  sanitiser and the REST schema.
- `unit` — appended on display only; the stored value stays raw. `USD` is
  rendered as a currency prefix instead of a suffix.
- `specs` — appears as a row in the Specs Table block.
- `compare` — appears as a row in the Compare Table block.

Meta keys carry no underscore prefix on purpose: unprotected meta with
`show_in_rest` is what makes a field usable from core block bindings.

## Adding a brand

Replace the file. No PHP changes are needed for new post types, taxonomies,
terms, meta fields, locations or social links. Indentation is 2 spaces.
