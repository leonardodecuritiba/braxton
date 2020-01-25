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
    'new_work_error' => 'Seu cadastro está inativo. Você precisa ativá-lo para adicionar novos trabalhos!',
    'store_ok' => 'Cadastro solicitado com sucesso. Verifique seu e-mail para confirmá-lo!',
    'validate_ok' => 'Cadastro realizado com sucesso.',
    'contato_ok' => 'Contato enviado com sucesso.',
    'username' => [
        'sent' => 'Um lembrete de LOGIN foi enviado para o seu e-mail!',
    ],
    'UPDATE-PASSWORD' => [
	    'SUCCESS' => 'Senha atualizada!',
    ],
    'crud' => [
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
		    'STORE'           => [
			    'SUCCESS'      => ':name cadastrado!',
			    'SUCCESS-MANY' => ':name cadastrados!',
			    'ERROR'        => 'Falha ao cadastrar o :name, tente novamente.',
			    'ERROR-MANY'   => 'Falha ao cadastrar os :name, tente novamente.',
		    ],
		    //UPDATE
		    'UPDATE'          => [
			    'SUCCESS'      => ':name atualizado!',
			    'SUCCESS-MANY' => ':name atualizados!',
			    'ERROR'        => 'Falha ao atualizar o :name, tente novamente.',
			    'ERROR-MANY'   => 'Falha ao atualizar os :name, tente novamente.',
		    ],
		    //DELETE
		    'DELETE'          => [
			    'SUCCESS'      => ':name removido!',
			    'SUCCESS-MANY' => ':name removidos!',
			    'ERROR'        => 'Falha ao remover o :name, tente novamente.',
			    'ERROR-MANY'   => 'Falha ao remover os :name, tente novamente.',
		    ],
		    //SEARCH
		    'SEARCH'          => [
			    'SUCCESS'      => 'Foi encontrado um :name!',
			    'SUCCESS-MANY' => 'Foram encontrados :count :name!',
			    'ERROR'        => 'Nenhum :name encontrado!',
		    ],
	    ],
	    'F'    => [
		    //UPDATE-PASSWORD
		    'UPDATE-PASSWORD' => [
			    'SUCCESS' => 'Senha atualizada!',
		    ],
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
			    'SUCCESS'      => ':name cadastrada!',
			    'SUCCESS-MANY' => ':name cadastradas!',
			    'ERROR'        => 'Falha ao cadastrar a :name, tente novamente.',
			    'ERROR-MANY'   => 'Falha ao cadastrar as :name, tente novamente.',
		    ],
		    //UPDATE
		    'UPDATE' => [
			    'SUCCESS'      => ':name atualizada!',
			    'SUCCESS-MANY' => ':name atualizadas!',
			    'ERROR'        => 'Falha ao atualizar a :name, tente novamente.',
			    'ERROR-MANY'   => 'Falha ao atualizar as :name, tente novamente.',
		    ],
		    //DELETE
		    'DELETE' => [
			    'SUCCESS'      => ':name removida!',
			    'SUCCESS-MANY' => ':name removidas!',
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
	    'MVS'  => ':name validado!',
	    'MVE'  => 'Erro ao validar o :name!',
	    'FVS'  => ':name validada!',
	    'FVE'  => 'Erro ao validar a :name!',

        //ACTIVE
	    'MAS'  => ':name ativado!',
	    'MAE'  => 'Erro ao ativar o :name!',
	    'FAS'  => ':name ativada!',
	    'FAE'  => 'Erro ao ativar a :name!',

        //DISACTIVE
	    'MDAS' => ':name desativado!',
	    'MDAE' => 'Erro ao desativar o :name!',
	    'FDAS' => ':name desativada!',
	    'FDAE' => 'Erro ao desativar a :name!',


        //DATA
	    'MDTS' => 'Dados do :name',
	    'FDTS' => 'Dados do :name',

        //LOGGED
	    'MLS'  => ':name logado!',
	    'MLE'  => 'Login/senha inválidos!',
	    'MLVE' => 'Este usuário ainda não foi validado! Por favor, clique no link enviado por email para validar sua conta!',

        //UNLOGGED
	    'MULS' => ':name deslogado!',
    ]

];
