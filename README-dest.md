# My App

This is the web app based on BEdita web app.

## Requirements

1. PHP >= 7.2
1. Download latest [Composer](https://getcomposer.org/doc/00-intro.md) or update via `composer self-update`.

## Install dependencies

Install composer dependencies.

```bash
composer install
```
## Setup folders

Check logs and tmp folder permissions: web server group should have permits to write.
If it doesn't, adjust permits. I.e.:

```bash
sudo chown -R user:www logs tmp
sudo chmod g+w -R logs tmp
```

## Start web app

Cleanup cache as follows:

```bash
bin/cake cache clear_all
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

You may then check `http://localhost:8765/credits` or `http://localhost:8765/{folder}` where `{folder}` is a folder uname on you BEdita4 project.

## Layout

The app skeleton uses [Milligram](https://milligram.io/) (v1.3) minimalist CSS
framework by default. You can, however, replace it with any other library or
custom styles.

## I18n

Internationalization behavior is not enabled by default.

To activate:

* in `config/app.php` uncomment `I18n` key and setup your wanted configuration
* in `src/Application.php` uncomment lines to add `I18nMiddleware` in `::middleware()` method
* in `config/routes.php` ucomment lines with `'routeClass' => 'BEdita/I18n.I18nRoute'` to enable routing rules

After that evey URL path will have a language prefix like `/en` automatically generated.
Using `I18nHelper` methods you may then handle URLs or object properties accordingly.
