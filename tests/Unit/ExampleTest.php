<?php

namespace Tests\Unit;

use Illuminate\Http\Request;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Controllers\OrganizacijaController;
use App\Models\Organizacija;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testStoreOrganizacija()
    {
        $org = new Organizacija();

        $org->naziv = 'asdasdasd';


        $this->assertTrue($org->save());
    }
}
