<?php
	//todos os arquivos ligado ao feed-item-script
	require_once 'config.php';
	require_once 'models/Auth.php';
	require_once 'dao/PostCommentDaoMysql.php';

	$auth = new Auth($pdo, $base);

	//armazenando a info do user
	$userInfo = $auth->checktoken();

	$id = filter_input(INPUT_POST, 'id');
	$txt = filter_input(INPUT_POST, 'txt');


	$array = [];

	if ($id && $txt) {
		$postCommentDao = new PostCommentDaoMysql($pdo);

		$newComment = new PostComment();
		$newComment->id_post = $id;
		$newComment->id_user = $userInfo->id;
		$newComment->body = $txt;
		$newComment->created_at = date('Y-m-d H:i:s');

		$postCommentDao->addComment($newComment);
		//montando o array
		$array = [
			'error' => '',
			'link' => $base.'/perfil.php?id='. $userInfo->id,
			'avatar' => $base .'/media/avatars'. $userInfo->avatar,
			'name' => $userInfo->name,
			'body' => $txt
		];

	}
	//transformando array em json
	header("Content-Type: application/json");
	echo json_encode($array);
	exit;