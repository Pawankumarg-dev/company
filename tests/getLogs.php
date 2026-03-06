<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Services\Logs\CandidateLogs;
use App\Services\Logs\Logs;

use Illuminate\Http\Request;

class getLogs extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->json('POST', '/posts', [
            'title' => 'test',
            'body' => 'this is a test'
        ]);
        
        $changes = new CandidateLogs(12,'name');
        $logs = new Logs($changes);

        $request = new Request(['perPage'=>100]);

        $logs->filter($request);

        $results =  $logs->getLogs(100);
        echo $results;
        $this->assertTrue(true);
    }
}
