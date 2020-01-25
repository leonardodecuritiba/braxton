<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Messages Language Lines
	|--------------------------------------------------------------------------
	| Model - Procedure Type - Message Type
	| Example 1: Fans (S)tore (S)uccess
	| Example 2: Fans (U)pdate (E)rror
	*/
	'view' => [
		'DATA'      => 'Dados',

		//STORE
		'CREATE'    => 'Cadastrar :name',
		'EDIT'      => 'Editar :name',
		'INDEX'     => 'Listar :name',
		'REPORT'    => 'Relatórios de :name',
		'NORESULTS' => [
			'M' => [ 'Nenhum :name encontrado!' ],
			'F' => [ 'Nenhuma :name encontrada!' ],
		],
		'OPEN'      => 'Abrir :name',
		'SHOW'      => 'Visualizar :name',
		'PROFILE'   => 'Meu Perfil',
	]

];
