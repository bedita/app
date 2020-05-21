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
namespace App\Test\TestCase\Controller;

use BEdita\WebTools\ApiClientProvider;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Cake\Utility\Hash;

/**
 * PagesControllerTest class
 *
 * {@see \App\Controller\PagesController} Test Case
 *
 * @coversDefaultClass \App\Controller\PagesController
 */
class PagesControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Instance of BEditaClient
     *
     * @var \BEdita\SDK\BEditaClient
     */
    protected $apiClient = null;

    /**
     * {@inheritDoc}
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->apiClient = ApiClientProvider::getApiClient();
        $response = $this->apiClient->authenticate(env('BEDITA_ADMIN_USR'), env('BEDITA_ADMIN_PWD'));
        $this->apiClient->setupTokens($response['meta']);
    }

    /**
     * {@inheritDoc}
     */
    public function tearDown(): void
    {
        parent::tearDown();

        $this->apiClient = null;
    }

    /**
     * Test home() method
     *
     * @return void
     *
     * @covers ::home()
     */
    public function testHome(): void
    {
        $this->get('/');
        $this->assertResponseOk();
        $this->assertLayout('default');
        $this->assertTemplate('home');
        $this->assertResponseContains('BEdita4 sample Web App');
    }

    /**
     * Test index() method with static template
     *
     * @return void
     *
     * @covers ::index()
     */
    public function testIndexStaticTemplate(): void
    {
        $this->get('/credits');
        $this->assertResponseOk();
        $this->assertLayout('default');
        $this->assertTemplate('credits');
        $this->assertResponseContains('Created by Gustavo');
    }

    /**
     * Test index() method with not found content
     *
     * @return void
     *
     * @covers ::index()
     */
    public function testIndexNotFound(): void
    {
        $this->get('/supporto');
        $this->assertResponseError();
        $this->assertLayout('error');
        $this->assertTemplate('error400');
        $this->assertResponseContains('Content not found');
    }

    /**
     * Test index method()
     *
     * @return void
     *
     * @covers ::index()
     */
    public function testIndex(): void
    {
        $res = $this->apiClient->save('folders', ['title' => 'Secrets of Gustavo']);
        $uname = Hash::get($res, 'data.attributes.uname');

        $this->get(sprintf('/%s', $uname));
        $this->assertResponseOk();
        $this->assertLayout('default');
        $this->assertTemplate('index');

        $folder = $this->viewVariable('folder');
        $children = $this->viewVariable('children');
        $included = $this->viewVariable('included');
        $this->assertResponseContains(Hash::get($folder, 'attributes.title'));
        static::assertEquals([], $children);
        static::assertEquals([], $included);
    }
}
