<?php 
	require_once 'config.php';
	require_once 'models/Auth.php';

	$auth = new Auth($pdo, $base);

	//armazenando a info do user
	$userInfo = $auth->checktoken();

 ?>