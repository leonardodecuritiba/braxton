<?php

use Illuminate\Database\Seeder;

class FullTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    //php artisan db:seed --class=FullTestSeeder
	    $this->command->call('migrate:refresh');
	    $this->call(DatabaseSeeder::class);
	    $this->call(TestSeeder::class);
    }
}
