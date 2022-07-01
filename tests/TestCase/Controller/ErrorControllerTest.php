<?php
declare(strict_types=1);

/**
 * BEdita, API-first content management framework
 * Copyright 2022 ChannelWeb Srl, Chialab Srl
 *
 * This file is part of BEdita: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published
 * by the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * See LICENSE.LGPL or <http://gnu.org/licenses/lgpl-3.0.html> for more details.
 */
namespace App\Test\TestCase\Controller;

use App\Controller\ErrorController;
use Cake\Event\Event;
use Cake\TestSuite\TestCase;

/**
 * ErrorControllerTest class
 *
 * {@see \App\Controller\ErrorController} Test Case
 *
 * @coversDefaultClass \App\Controller\ErrorController
 */
class ErrorControllerTest extends TestCase
{
    /**
     * Test initialize() method
     *
     * @return void
     * @covers ::initialize()
     */
    public function testInitialize(): void
    {
        $controller = new ErrorController();
        $controller->initialize();
        static::assertTrue($controller->components()->has('RequestHandler'));
    }

    /**
     * Test beforeRender() method
     *
     * @return void
     * @covers ::beforeRender()
     */
    public function testBeforeRender(): void
    {
        $controller = new ErrorController();
        $controller->beforeRender(new Event('test'));
        static::assertEquals('Error', $controller->viewBuilder()->getTemplatePath());
    }
}
