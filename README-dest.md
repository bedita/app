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

Logs and tmp folder permissions should be fine (`composer install` deals with them).
For further details about permissions in cakephp, look at https://book.cakephp.org/4/en/installation.html#permissions

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

## TwigView

The app uses `BEdita\WebTools\TwigView` (that extends [`Cake\TwigView`](https://github.com/cakephp/twig-view)) as `AppView`.

You can customize [Twig Environment](https://twig.symfony.com/doc/3.x/api.html#environment-options) uncommenting `Twig` key in `config/app.php`.

## I18n

Internationalization behavior is not enabled by default.

To activate:

* in `config/app.php` uncomment `I18n` key and setup your wanted configuration
* in `src/Application.php` load `BEdita/I18n` plugin with middleware enabled
  ```php
  $this->addPlugin('BEdita/I18n', ['middleware' => true]);
  ```
* in `config/routes.php` uncomment lines with `'routeClass' => 'BEdita/I18n.I18nRoute'` to enable routing rules

After that evey URL path will have a language prefix like `/en` automatically generated.
Using `I18nHelper` methods you may then handle URLs or object properties accordingly.

## Setup AssetsRevisions

In order to handle assets revisions uncomment in `src/Application.php` the following rows in `boostrap()` method:

```php
\BEdita\WebTools\Utility\AssetsRevisions::setStrategy(
    new \BEdita\WebTools\Utility\Asset\Strategy\EntrypointsStrategy()
);
```

For more information about assets revisions and strategies to adopt see [here](https://github.com/bedita/web-tools#load-assets-with-assetrevisions).
