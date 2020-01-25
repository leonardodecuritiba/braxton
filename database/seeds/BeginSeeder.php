<?php

use Illuminate\Database\Seeder;

class BeginSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //php artisan db:seed --class=BeginSeeder
        $start = microtime(true);

	    $this->call( CepTablesSeed::class );
	    $this->command->info( 'CepTablesSeed complete ...' );

	    $this->call( ZizacoSeeder::class );
	    $this->command->info( 'ZizacoSeeder complete ...' );

	    $this->call( SensorTypeTableSeeder::class );
	    $this->command->info( 'SensorTypeTableSeeder complete ...' );

        $this->command->info("*** BeginSeeder realizada com sucesso em " . round((microtime(true) - $start), 3) . "s ***");

    }
}
