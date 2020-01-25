<?php

use Illuminate\Database\Seeder;

use App\Models\Admins\Admin;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    set_time_limit(3600);
	    $this->call(BeginSeeder::class);

	    factory(Admin::class, 2)->create();
	    $this->command->info('Admin complete ...');

	    $Admin = Admin::find(1);
	    $Admin->user->update(['name'=>'Silvio','email'=>'silvio@braxton.com.br']);

	    $Admin = Admin::find(2);
	    $Admin->user->update(['name'=>'Leonardo','email'=>'silva.zanin@gmail.com']);

//
//        $destinationPath = public_path(
//            'uploads'
//        );
//        \File::deleteDirectory($destinationPath);
//        \File::makeDirectory($destinationPath, $mode = 0777, true, true);
//
//        $destinationPath = $destinationPath . DIRECTORY_SEPARATOR . 'products';
//        \File::makeDirectory($destinationPath, $mode = 0777, true, true);
    }
}
