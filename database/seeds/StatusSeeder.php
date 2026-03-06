<?php

use Illuminate\Database\Seeder;

use App\Status;
class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Status::create(['status' => 'Pending', 'class' => 'warning']);
        Status::create(['status' => 'Approved', 'class' => 'success']);
        Status::create(['status' => 'Rejected', 'class' => 'danger']);
    }
}
