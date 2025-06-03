<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LandingPageTest extends DuskTestCase
{
    public function testLandingPageLoads()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertSeeIn('h1', 'Project Management System');
        });
    }
}