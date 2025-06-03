<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class TCC001 extends DuskTestCase
{
    public function testAddClientSuccessfully()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/login')
                ->pause(2000)
                ->waitFor('form')
                ->type('email', 'admin@gmail.com')
                ->type('password', 'admin')
                ->press('Sign in')
                ->waitForText('Dashboard')
                ->assertPathIs('/admin/dashboard');
        });
    }
}