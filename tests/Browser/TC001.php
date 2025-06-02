<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class TC001 extends DuskTestCase
{
    /**
     * A Dusk test example.
     */

    /** @test */

    public function tambah_reimburse_dengan_data_lengkap()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/login')
                    ->pause(1000) // agar input sempat muncul
                    ->type('[name="data.email"]', 'rahil@gmail.com')
                    ->type('[name="data.password"]', '12345678')
                    ->press('Sign in')
                    ->pause(1000)
                    ->assertPathIsNot('/admin/login');
        });
    }
}
