<?php
	require_once 'config.php';
	require_once 'models/Auth.php';
	require_once 'dao/PostDaoMysql.php';

	$auth = new Auth($pdo, $base);

	//armazenando a info do user
	$userInfo = $auth->checktoken();

	$id = filter_input(INPUT_GET, 'id');

	//recebendo o body
	if ($id) {
		$postDao = new PostDaoMysql($pdo);

		$postDao->delete($id, $userInfo->id);

	}

	header("Location:". $base);
	exit;