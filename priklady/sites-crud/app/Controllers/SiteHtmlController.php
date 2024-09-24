<?php

namespace App\Controllers;

use App\Router;
use App\SitesRepository;
use Exception;

class SiteHtmlController
{
    /**
     * @throws Exception
     */
    public function show(Router $router): string
    {
        $params = $router->getCurrentEndpoint()->getUrlParams();
        $idOrSlug = $params['site'];

        $repository = new SitesRepository();

        if (is_numeric($idOrSlug))
        {
            $site = $repository->findById((int) $idOrSlug) ?? $repository->findBySlug((string) $idOrSlug);
        }
        else if (isset($idOrSlug))
        {
            $site = $repository->findBySlug($idOrSlug);
        }
        else {
            $site = null;
        }

        if (!$site)
        {
            throw new Exception('Site not found', 404);
        }

        return layout($site->name, function () use ($site) {
            return "<h1> $site->name </h1> <p> $site->slug </p>";
        });
    }
}