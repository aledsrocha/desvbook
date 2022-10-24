<?php
	require_once 'config.php';
	require_once 'models/Auth.php';
	require_once 'dao/PostDaoMysql.php';

	$auth = new Auth($pdo, $base);

	//armazenando a info do user
	$userInfo = $auth->checktoken();

	$body = filter_input(INPUT_POST, 'body');

	//recebendo o body
	if ($body) {
		$postDao = new PostDaoMysql($pdo);

		$newPost = new Post();
		//pegando o usuario logado que vai fazer a postagem
		$newPost->id_user = $userInfo->id;
		//por enquanto so pegando texto que postou
		$newPost->type = 'text';
		//a hora da postagem
		$newPost->create_at = date('Y-m-d H:i:s');
		
		$newPost->body = $body;
		
		$postDao->insert($newPost);
	}

	header("Location:". $base);
	exit;