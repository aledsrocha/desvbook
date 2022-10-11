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

		public function validateLogin($email, $password){
			$userDao = new UserDaoMysql($this->pdo);

			$user = $userDao->findByEmail($email);
			//verificando se existe usuario
			if ($user) {
				//verificando a senha
				if (password_verify($password, $user->password)) {
					$token = md5(time().rand(0, 9999));

					$_SESSION['token'] = $token;
					$user->token = $token;
					$userDao->update($user);

					return true;
				}
			}//$user

			return false;
		}//validate login

		public function emailExists($email){
			$userDao = new UserDaoMysql($this->pdo);

			return $userDao->findByEmail($email) ? true : false ;
		}
		//registro de novo usuario para fazer login apos o cadastro necessario criar o token
		public function registerUser($name, $password, $email, $birthdate){
			$userDao = new UserDaoMysql($this->pdo);

			$hash = password_hash($password, PASSWORD_DEFAULT);
			$token = md5(time().rand(0, 9999));

			$newUser = new User();
			$newUser->name = $name;
			$newUser->email = $email;
			$newUser->password = $hash;
			$newUser->birthdate = $birthdate;
			$newUser->token = $token;

			$userDao->insert($newUser);

			$_SESSION['token'] = $token;
		}
	}//class
 ?>