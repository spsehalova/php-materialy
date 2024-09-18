<?php

namespace Tests;

use App\SiteModel;
use App\SitesRepository;
use PHPUnit\Framework\TestCase;
class SitesTest extends TestCase
{
    public function testSiteModel()
    {
        $repository = new SitesRepository();

        $siteOne = new SiteModel();
        $siteOne->name = 'Site One';
        $siteOne->slug = 'site-one';

        $siteOne->save();

        $this->assertNotNull($siteOne->getId());

        $fetchedSite = $repository->findById($siteOne->getId());
        $this->assertNotNull($fetchedSite);
        $this->assertEquals($siteOne->name, $fetchedSite->name);
        $this->assertEquals($siteOne->slug, $fetchedSite->slug);

        $siteOne->name = 'Site One Updated';
        $siteOne->slug = 'site-one-up';
        $siteOne->save();

        $fetchedSite = $repository->findById($siteOne->getId());
        $this->assertNotNull($fetchedSite);
        $this->assertEquals($siteOne->name, $fetchedSite->name);
        $this->assertEquals($siteOne->slug, $fetchedSite->slug);
        
        $siteOne->delete();

        $this->assertNull($repository->findById($siteOne->getId()));
    }

    public function testRepository()
    {
        $repository = new SitesRepository();

        $sites = $repository->getSites();

        $this->assertIsArray($sites);

        $siteOne = new SiteModel();
        $siteOne->name = 'Site One';
        $siteOne->slug = 'site-one';

        $siteOne->save();

        $siteTwo = new SiteModel();
        $siteTwo->name = 'Site Two';
        $siteTwo->slug = 'site-two';

        $siteTwo->save();

        $sites = $repository->getSites();

        $this->assertTrue(count($sites) >= 2);

        foreach ($sites as $site)
        {
            $this->assertInstanceOf(SiteModel::class, $site);
        }
    }
}
