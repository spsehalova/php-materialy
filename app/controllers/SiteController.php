<?php

namespace App\Controllers;

use App\Router;
use App\SiteModel;
use App\SitesRepository;
use Exception;

class SiteController
{
    public function index(): array
    {
        $repository = new SitesRepository();

        $sites = $repository->getSites();

        return array_map(function (SiteModel $siteModel) {
            return $siteModel->toArray();
        }, $sites);
    }

    /**
     * @throws Exception
     */
    public function show(Router $router): SiteModel
    {
        $params = $router->getCurrentEndpoint()->getUrlParams();
        $idOrSlug = $params['site'];

        $repository = new SitesRepository();

        $site = $repository->findById($idOrSlug) ?? $repository->findBySlug($idOrSlug);

        if (!$site)
        {
            throw new Exception('Site not found', 404);
        }

        return $site;
    }
}