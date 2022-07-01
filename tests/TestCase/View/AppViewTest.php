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
namespace App\Test\TestCase\View;

use App\View\AppView;
use Cake\TestSuite\TestCase;

/**
 * AppViewTest class
 *
 * {@see \App\View\AppView} Test Case
 *
 * @coversDefaultClass \App\View\AppView
 */
class AppViewTest extends TestCase
{
    /**
     * Test initialize() method
     *
     * @return void
     * @covers ::initialize()
     */
    public function testInitialize(): void
    {
        $view = new AppView();
        $view->initialize();

        static::assertTrue($view->helpers()->has('Flash'));
        static::assertTrue($view->helpers()->has('Html'));
        static::assertTrue($view->helpers()->has('Thumb'));
        static::assertTrue($view->helpers()->has('I18n'));
    }
}
