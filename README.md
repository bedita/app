# BEdita App

This is the BEdita skeleton web app.

## Requirements

1. PHP >= 7.2
1. Download latest [Composer](https://getcomposer.org/doc/00-intro.md) or update via `composer self-update`.

## Installation

Simply run

```bash
composer create-project bedita/app
```

In case you want to use a custom app dir name (e.g. `/myapp/`):

```bash
composer create-project bedita/app myapp
```

You can now either use your machine's webserver to view the default home page, or start
up the built-in webserver with:

```bash
bin/cake server
```

Then visit `http://localhost:8765` to see the welcome page.

## Configuration

Read and edit the environment specific in `config/.env` in particular:

* `BEDITA_API` and `BEDITA_API_KEY` to setup API endpoint
* `DEBUG` set to `"true"` or `"false"`to activate/deactivate debug mode

Other environment agnostic settings can be changed in `config/app.php`.

## Layout

The app skeleton uses [Milligram](https://milligram.io/) (v1.3) minimalist CSS
framework by default. You can, however, replace it with any other library or
custom styles.
