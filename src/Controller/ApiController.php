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
namespace App\Controller;

use BEdita\WebTools\Controller\ApiProxyTrait;

/**
 * ApiController class.
 *
 * It proxies requests to BEdita 4 API.
 * The response will be the same of the API itself.
 *
 * To use this controller assure to have the right routing rules applied
 * for each HTTP method you want to activate, for example:
 *
 * ```
 * // $builder is \Cake\Routing\RouteBuilder intance
 * $builder->scope('/api', ['_namePrefix' => 'api:'], function (RouteBuilder $builder) {
 *     $builder->get('/**', ['controller' => 'Api', 'action' => 'get'], 'get');
 * });
 * ```
 *
 * Every request to `/api/*` will be delegated to BEditaClient and the raw json response will be returned.
 * For example:
 *
 * ```
 * GET /api/users/1
 * ```
 *
 * will be forwarded to `GET /users/1` of BEdita 4 API.
 */
class ApiController extends AppController
{
    use ApiProxyTrait;
}
