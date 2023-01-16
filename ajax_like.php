<?php

	require_once 'config.php';
	require_once 'models/Auth.php';
	require_once 'dao/PostLikeDaoMysql.php';

	$auth = new Auth($pdo, $base);

	//armazenando a info do user
	$userInfo = $auth->checktoken();

	$id = filter_input(INPUT_GET, 'id');
	$body = filter_input(INPUT_POST, 'body');

	if (!empty($id)) {
		$postLikeDao = new PostLikeDaoMysql($pdo);

		$postLikeDao->likeTogger($id, $userInfo->id);
	}
