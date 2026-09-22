# Setup

Four commands from a fresh clone to a fully seeded demo site. Nothing is installed on
your machine except Docker — no PHP, no MySQL, no Node.

## Before you start

Install **OrbStack** (https://orbstack.dev) or **Docker Desktop** (https://docker.com),
and start it. Either works; OrbStack is lighter on a Mac. You also need `make`, which
ships with macOS and every Linux.

Check it is running:

```sh
docker info
```

## Run it

```sh
git clone <this repository>
cd emeraldpool.com

cp .env.example .env     # 1. credentials and port — the defaults are fine
make up                  # 2. start WordPress and MariaDB
make install             # 3. install WordPress, activate the theme and plugin
make seed                # 4. import the images, spas, pages, menu and posts
```

The first run pulls the container images, so give it a few minutes. After that it is
seconds.

Then open:

| | |
|---|---|
| Site | http://localhost:8080 |
| Admin | http://localhost:8080/wp-admin |
| User | `admin` |
| Password | `admin` |

## What you should see

A complete twelve-page site: a home page, Hot Tubs and Swim Spas listings, ten spa
model pages, Services, Financing, About, Contact, FAQ, Accessibility, Privacy, and a
Journal with three posts. Every image is real and every link resolves.

In the admin, **Pages → Home → Edit** opens the block editor. The blocks live in the
inserter under a category named **Emerald Pool**.

## Everyday commands

```sh
make down                # stop (your data is kept)
make up                  # start again
make reset               # wipe the database and start over, then run `make seed`
make logs                # tail the container logs
```

## If something goes wrong

**Port 8080 is already taken.** Edit `.env`, set `WP_PORT` and `WP_URL` to another port
(for example `8090` and `http://localhost:8090`), then `make down && make up && make install`.

**`make seed` says a file is missing.** The images live in `research/assets/` and are
committed to the repository. Confirm the clone is complete — `git status` should be clean.

**The site looks unstyled.** The theme was not activated. Run `make install` again;
it is safe to repeat.

**Starting completely over.** `make reset` destroys the database volume and reinstalls,
then run `make seed`.

---

`README.md` is the full reference — the make targets, the folder map and the notes.
`docs/SEED.md` explains what the seed creates and how to point it at another brand.
