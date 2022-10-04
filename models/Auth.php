<?php 
	require_once 'dao/UserDaoMysql.php';
	class Auth{
		private $pdo;
		private $base;
		//construct para salvar os dados
		public function __construct($pdo, $base){
			$this->pdo = $pdo;
			$this->base = $base;

		}

		public function checkToken(){
			//verificando se existe a sessão
			if (!empty($_SESSION['token'])) {
				//armazenando o token
				$token = $_SESSION['token'];

				$userDao = new UserDaoMysql($this->pdo);
				$user = $userDao->findByToken($token);

				//verificando se existe o usuario se existir retorna ele msm
				if ($user) {
					return $user;
				}


			}//empty

			header("Location: " . $this->base . "/login.php");
			exit;

		}//checktoken
	}//class
 ?>