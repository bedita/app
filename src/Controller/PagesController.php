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

use BEdita\SDK\BEditaClientException;
use Cake\Http\Exception\NotFoundException;
use Cake\Utility\Hash;
use Cake\Utility\Inflector;

/**
 * Static & folder content controller
 *
 * This controller will render views from templates/Pages/
 *
 * @link https://book.cakephp.org/4/en/controllers/pages-controller.html
 */
class PagesController extends AppController
{
    /**
     * List of static template pages, each one will be served via `/{name}` or `/:lang/{name}` URL
     * A template with the same name must exist.
     *
     * @var array
     */
    public const STATIC_TEMPLATES = [
        'credits',
    ];

    /**
     * Home page
     *
     * @return void
     */
    public function home(): void
    {
    }

    /**
     * List contents in a folder or display static content page
     *
     * @param int|string $item Static page or folder id/uname.
     * @return void
     */
    public function index($item): void
    {
        if (in_array($item, self::STATIC_TEMPLATES)) {
            $this->viewBuilder()->setTemplate(sprintf('%s', $item));

            return;
        }

        $lang = $this->getLang();
        try {
            $resp1 = $this->apiClient->getObject($item, 'folders', compact('lang'));
            $resp2 = $this->apiClient->getRelated($item, 'folders', 'children', compact('lang'));
        } catch (BEditaClientException $ex) {
            throw new NotFoundException(__('Content not found'));
        }

        $folder = (array)Hash::get((array)$resp1, 'data');
        $children = (array)Hash::get((array)$resp2, 'data');

        $included = (array)Hash::get((array)$resp1, 'included', []);
        $included = array_merge($included, (array)Hash::get((array)$resp2, 'included', []));
        $this->set(compact('folder', 'children', 'included'));

        // Load custom template if available
        $template = sprintf('%s/templates/Pages/%s.twig', ROOT, Inflector::underscore((string)$item));
        if (file_exists($template)) {
            $this->viewBuilder()->setTemplate((string)$item);
        }
    }
}
