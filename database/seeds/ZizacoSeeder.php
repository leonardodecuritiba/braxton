<?php

use Illuminate\Database\Seeder;
use \App\Models\Users\Collaborator;
use \App\Models\Users\Role;
use \App\Models\Users\Permission;

class ZizacoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //php artisan db:seed --class=ZizacoSeeder
	    $start = microtime( true );
	    $this->command->info( 'Iniciando os Seeders ZizacoSeeder' );
	    $this->command->info( 'SETANDO Administrador' );
	    $admin               = new Role(); // Gerência = tudo
	    $admin->name         = 'admin';
	    $admin->display_name = 'Administrador'; // optional
	    $admin->description  = 'Usuário com acesso total ao sistema'; // optional
	    $admin->save();

	    $this->command->info( 'SETANDO Cliente' );
	    $client               = new Role();
	    $client->name         = 'client'; //Preenchimento de requisição + cadastro de clientes
	    $client->display_name = 'Cliente'; // optional
	    $client->description  = 'Usuário com acessos restritos'; // optional
	    $client->save();

	    $this->command->info( 'SETANDO SubClientes' );
	    $sub_client               = new Role();
	    $sub_client->name         = 'sub_client'; //Preenchimento de requisição + cadastro de clientes
	    $sub_client->display_name = 'SubClientes'; // optional
	    $sub_client->description  = 'Usuário com acessos restritos'; // optional
	    $sub_client->save();

	    //SETANDO PERMISSÕES
	    $arrays = ['admins','dashboards','clients','sub_clients','devices','sensors','sensor_types','alerts','reports','permissions'];
	    $options = ['index','create','edit','active','destroy'];

	    foreach($arrays as $array){
		    foreach($options as $option){
			    $data = new Permission();
			    $data->name         = $array.'.'.$option;
			    $data->display_name = $array.'.'.$option; // optional
			    $data->save();

			    $admin->attachPermission($data);
			    if(($array != 'admins') && ($array != 'clients') && ($array != 'sensor_types') && ($array != 'permissions')){
				    $client->attachPermission($data);
				    if(($array != 'sub_clients')){
					    $sub_client->attachPermission($data);
				    }
			    }
		    }
	    }

        echo "\n*** Completo em " . round((microtime(true) - $start), 3) . "s ***";
    }
}
