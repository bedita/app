<?php
declare(strict_types=1);

/**
 * BEdita, API-first content management framework
 * Copyright 2020 ChannelWeb Srl, Chialab Srl
 *
 * This file is part of BEdita: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published
 * by the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * See LICENSE.LGPL or <http://gnu.org/licenses/lgpl-3.0.html> for more details.
 */

namespace App\Test\TestCase;

use App\Application;
use BEdita\I18n\Middleware\I18nMiddleware;
use Cake\Error\Middleware\ErrorHandlerMiddleware;
use Cake\Http\Middleware\BodyParserMiddleware;
use Cake\Http\MiddlewareQueue;
use Cake\Routing\Middleware\AssetMiddleware;
use Cake\Routing\Middleware\RoutingMiddleware;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * ApplicationTest class
 *
 * {@see \App\Application} Test Case
 *
 * @coversDefaultClass \App\Application
 */
class ApplicationTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * testBootstrap
     *
     * @return void
     *
     * @covers ::bootstrap()
     * @covers ::bootstrapCli()
     */
    public function testBootstrap()
    {
        $app = new Application(dirname(dirname(__DIR__)) . '/config');
        $app->bootstrap();
        $plugins = $app->getPlugins();

        $this->assertCount(4, $plugins);
        $this->assertSame('BEdita/I18n', $plugins->get('BEdita/I18n')->getName());
        $this->assertSame('BEdita/WebTools', $plugins->get('BEdita/WebTools')->getName());
        $this->assertSame('DebugKit', $plugins->get('DebugKit')->getName());
        $this->assertSame('Bake', $plugins->get('Bake')->getName());
    }

    /**
     * testMiddleware
     *
     * @return void
     */
    public function testMiddleware()
    {
        $app = new Application(dirname(dirname(__DIR__)) . '/config');
        $middleware = new MiddlewareQueue();

        $app->addPlugin('BEdita/I18n', ['middleware' => true]);
        $middleware = $app->middleware($middleware);
        $app->pluginMiddleware($middleware);

        $this->assertInstanceOf(ErrorHandlerMiddleware::class, $middleware->current());
        $middleware->seek(1);
        $this->assertInstanceOf(AssetMiddleware::class, $middleware->current());
        $middleware->seek(2);
        $this->assertInstanceOf(I18nMiddleware::class, $middleware->current());
        $middleware->seek(3);
        $this->assertInstanceOf(RoutingMiddleware::class, $middleware->current());
        $middleware->seek(4);
        $this->assertInstanceOf(BodyParserMiddleware::class, $middleware->current());
    }
}
