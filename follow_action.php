<?php
	require_once 'config.php';
	require_once 'models/Auth.php';
	require_once 'dao/UserRelationDaoMysql.php';
	require_once 'dao/UserDaoMysql.php';

	$auth = new Auth($pdo, $base);

	//armazenando a info do user
	$userInfo = $auth->checktoken();

	$id = filter_input(INPUT_GET, 'id');

	
	if ($id) {

		$userRelationDao = new UserRelationDaoMysql($pdo);
		$UserDao = new UserDaoMysql($pdo);

		//verificando se ta seguindo o usuario existentente
		if ($UserDao->findById($id)) {
			$relation = new UserRelation();
			$relation->user_from = $userInfo->id;
			$relation->user_to = $id;
			
			//verificando se seguimos esse usuario para seguir ou  nao
			if ($userRelationDao->isFollowing($userInfo->id, $id)) {
				//unfollow
					
				$userRelationDao->delete($relation);

			}//userrelation
			else{
				//follow
					
				$userRelationDao->insert($relation);
			}
		}//userdao
	}

	header("Location:". $base);
	exit;