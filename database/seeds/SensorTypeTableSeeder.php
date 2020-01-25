<?php

use Illuminate\Database\Seeder;

class SensorTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    //php artisan db:seed --class=MagnitudeTableSeeder
	    $start = microtime(true);
	    $filename = 'sensor_types.csv';
	    $this->command->info( "*** Iniciando o Upload (" . $filename . ") ***" );

	    $file = storage_path( 'import' . DIRECTORY_SEPARATOR . $filename );
	    $this->command->info( "*** Upload completo em " . round( ( microtime( true ) - $start ), 3 ) . "s ***" );

	    $rows = Excel::load( $file, function ( $reader ) {
		    $reader->toArray();
		    $reader->noHeading();
	    } )->get();

	    foreach ( $rows as $key => $row ) {
	    	if($key>0){
	    		$range = explode(';',$row[4]);
			    $data = [
				    'code'          => $row[0],
				    'description'   => $row[1],
				    'scale'         => $row[2],
				    'scale_name'    => $row[3],
				    'range'         => $range,
				    'type'          => $row[5],
			    ];
			    \App\Models\Commons\SensorType::create( $data );

		    }
	    }
    }
}
