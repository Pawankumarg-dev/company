<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Services\Payments\Receiver\NBER;
use App\Services\Payments\Receiver\RCI;

use App\Services\Payments\Configuration\Keys;


class getPaymentConfiguration extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        echo PHP_EOL . "Getting Configurations RCI" . PHP_EOL;
        $receiver = new RCI();
        $this->getKeys($receiver);
        $this->assertTrue(true);
        for($i = 1; $i<=3; $i++) {
            echo PHP_EOL. "Getting Configurations NBER #".$i. "". PHP_EOL;;
            $receiver = new NBER($i);
            $this->getKeys($receiver);
            $this->assertTrue(true);
        }
    }

    private function getKeys($receiver){
        $key = new Keys($receiver);
        echo "Code: " . $key->getAccessCode(). PHP_EOL;
        echo "Merchant ID: " .$key->getMarchentID(). PHP_EOL;
        echo "Key: " .$key->getWorkingKey(). PHP_EOL;
    }
}

