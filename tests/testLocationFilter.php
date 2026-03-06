<?php
use Illuminate\Http\Request;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Services\LocateInstitute\States;
use App\Services\LocateInstitute\Courses;
use App\Services\LocateInstitute\Institutes;


class testLocationFilter extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $request = new Request();
        $request->replace(['state_id' => 2]);
        $state = new States($request);
        echo $state->getSelected();
        echo $state->getDropdownData(['']);
        $coures = new Courses($request);
        echo $coures->getDropdownData(['state_id'=>3]);
        echo $coures->getDropdownData(['state_id'=>'null']);
        $institutes = new Institutes($request);
        echo $institutes->getDropdownData(['state_id'=>3,'course_id'=>19]);
        $this->assertTrue(true);
    }
}
