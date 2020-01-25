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
	'store_ok'    => 'Cadastro solicitado com sucesso. Verifique seu e-mail para confirmá-lo!',
	'validate_ok' => 'Cadastro realizado com sucesso.',
	'contato_ok'  => 'Contato enviado com sucesso.',
	'username'    => [
		'sent' => 'Um lembrete de LOGIN foi enviado para o seu e-mail!',
	],
	'crud'        => [
		'M'    => [
			//CREATE
			'CREATE' => [
				'GET-FORM'   => 'Novo :name',
				'TITLE-FORM' => 'Cadastrar Novo :name',
			],
			//EDIT
			'EDIT'   => [
				'TITLE-FORM' => 'Editar :name',
			],
			//STORE
			'STORE'  => [
				'SUCCESS'      => ':name cadastrado com sucesso!',
				'SUCCESS-MANY' => ':name cadastrados com sucesso!',
				'ERROR'        => 'Falha ao cadastrar o :name, tente novamente.',
				'ERROR-MANY'   => 'Falha ao cadastrar os :name, tente novamente.',
			],
			//UPDATE
			'UPDATE' => [
				'SUCCESS'      => ':name atualizado com sucesso!',
				'SUCCESS-MANY' => ':name atualizados com sucesso!',
				'ERROR'        => 'Falha ao atualizar o :name, tente novamente.',
				'ERROR-MANY'   => 'Falha ao atualizar os :name, tente novamente.',
			],
			//DELETE
			'DELETE' => [
				'SUCCESS'      => ':name removido com sucesso!',
				'SUCCESS-MANY' => ':name removidos com sucesso!',
				'ERROR'        => 'Falha ao remover o :name, tente novamente.',
				'ERROR-MANY'   => 'Falha ao remover os :name, tente novamente.',
			],
			//SEARCH
			'SEARCH' => [
				'SUCCESS'      => 'Foi encontrado um :name!',
				'SUCCESS-MANY' => 'Foram encontrados :count :name!',
				'ERROR'        => 'Nenhum :name encontrado!',
			],
		],
		'F'    => [
			//CREATE
			'CREATE' => [
				'GET-FORM'   => 'Nova :name',
				'TITLE-FORM' => 'Cadastrar Nova :name',
			],
			//EDIT
			'EDIT'   => [
				'TITLE-FORM' => 'Editar :name',
			],
			//STORE
			'STORE'  => [
				'SUCCESS'      => ':name cadastrada com sucesso!',
				'SUCCESS-MANY' => ':name cadastradas com sucesso!',
				'ERROR'        => 'Falha ao cadastrar a :name, tente novamente.',
				'ERROR-MANY'   => 'Falha ao cadastrar as :name, tente novamente.',
			],
			//UPDATE
			'UPDATE' => [
				'SUCCESS'      => ':name atualizada com sucesso!',
				'SUCCESS-MANY' => ':name atualizadas com sucesso!',
				'ERROR'        => 'Falha ao atualizar a :name, tente novamente.',
				'ERROR-MANY'   => 'Falha ao atualizar as :name, tente novamente.',
			],
			//DELETE
			'DELETE' => [
				'SUCCESS'      => ':name removida com sucesso!',
				'SUCCESS-MANY' => ':name removidas com sucesso!',
				'ERROR'        => 'Falha ao remover a :name, tente novamente.',
				'ERROR-MANY'   => 'Falha ao remover as :name, tente novamente.',
			],
			//SEARCH
			'SEARCH' => [
				'SUCCESS'      => 'Foi encontrada uma :name!',
				'SUCCESS-MANY' => 'Foram encontradas :count :name!',
				'ERROR'        => 'Nenhuma :name encontrada!',
			],
		],

		//VALIDATE
		'MVS'  => ':name validado com sucesso!',
		'MVE'  => 'Erro ao validar o :name!',
		'FVS'  => ':name validada com sucesso!',
		'FVE'  => 'Erro ao validar a :name!',

		//ACTIVE
		'MAS'  => ':name ativado com sucesso!',
		'MAE'  => 'Erro ao ativar o :name!',
		'FAS'  => ':name ativada com sucesso!',
		'FAE'  => 'Erro ao ativar a :name!',

		//DISACTIVE
		'MDAS' => ':name desativado com sucesso!',
		'MDAE' => 'Erro ao desativar o :name!',
		'FDAS' => ':name desativada com sucesso!',
		'FDAE' => 'Erro ao desativar a :name!',


		//DATA
		'MDTS' => 'Dados do :name',
		'FDTS' => 'Dados do :name',

		//LOGGED
		'MLS'  => ':name logado com sucesso!',
		'MLE'  => 'Login/senha inválidos!',
		'MLVE' => 'Este usuário ainda não foi validado! Por favor, clique no link enviado por email para validar sua conta!',

		//UNLOGGED
		'MULS' => ':name deslogado com sucesso!',
	]

];
