<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use Illuminate\Http\Request;

use App\Services\Institutes\ListOfInstitutes;
use App\Services\Common\HelperService;

class getNberInstitutes extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $request = new Request();
        $institutes = new ListOfInstitutes(-1,1);
        echo $institutes->getInstitutes();
        $this->assertTrue(true);
    }
}
