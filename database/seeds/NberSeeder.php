<?php

use Illuminate\Database\Seeder;

use App\User;

class NberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	User::create(['username'=>'jeopaul','email'=>'jeopaul2008@gmail.com','password'=>bcrypt('NiepmdNber@2017')]);
		User::create(['username'=>'saranya','email'=>'9791147072@gmail.com','password'=>bcrypt('NiepmdNber@2017')]);
		User::create(['username'=>'hemalatha','email'=>'9941591522@gmail.com','password'=>bcrypt('NiepmdNber@2017')]);
		User::create(['username'=>'gunasekaran','email'=>'8056832302@gmail.com','password'=>bcrypt('NiepmdNber@2017')]);
		User::create(['username'=>'kothandaraman','email'=>'9042906313@gmail.com','password'=>bcrypt('NiepmdNber@2017')]);
		User::create(['username'=>'sobhanam','email'=>'9790725515@gmail.com','password'=>bcrypt('NiepmdNber@2017')]);
		User::create(['username'=>'kiruthika','email'=>'9514755536@gmail.com','password'=>bcrypt('NiepmdNber@2017')]);
		User::create(['username'=>'nqanapriya','email'=>'7598402757@gmail.com','password'=>bcrypt('NiepmdNber@2017')]);
		User::create(['username'=>'vinya','email'=>'7598695653@gmail.com','password'=>bcrypt('NiepmdNber@2017')]);
		User::create(['username'=>'archana','email'=>'archana@gmail.com','password'=>bcrypt('NiepmdNber@2017')]);
		User::create(['username'=>'rubesh','email'=>'rubesh@gmail.com','password'=>bcrypt('NiepmdNber@2017')]);
		User::create(['username'=>'santhiya','email'=>'santhiya@gmail.com','password'=>bcrypt('NiepmdNber@2017')]);
		
		///newly added users
		User::create(['username'=>'bharath','email'=>'bharathn140@gmail.com','password'=>bcrypt('NiepmdNber@2017')]);
		User::create(['username'=>'maniram','email'=>'hajaremaniram@gmail.com','password'=>bcrypt('NiepmdNber@2017')]);
		User::create(['username'=>'abijit','email'=>'abijit.a.1991@gmail.com','password'=>bcrypt('NiepmdNber@2017')]);
		User::create(['username'=>'kavitha','email'=>'kavianil19@gmail.com','password'=>bcrypt('NiepmdNber@2017')]);
		
	}
}