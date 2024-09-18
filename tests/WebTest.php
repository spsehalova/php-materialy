<?php

namespace Tests;

use App\Config;
use App\SitesRepository;
use PHPUnit\Framework\TestCase;

class WebTest extends TestCase
{
    public function testIndex()
    {
        $ch = curl_init(Config::URL);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);

        foreach ((new SitesRepository())->getSites() as $site)
        {
            $this->assertStringContainsString($site->name, $response);
        }
    }
}
