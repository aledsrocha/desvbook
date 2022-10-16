<?php 
	require_once 'dao/UserDaoMysql.php';
	class Auth{
		private $pdo;
		private $base;
		private $dao;
		//construct para salvar os dados
		public function __construct(PDO $pdo, $base){
			$this->pdo = $pdo;
			$this->base = $base;
			$this->dao = new UserDAOMySql($this->pdo);

		}

		public function checkToken(){
			//verificando se existe a sessão
			if (!empty($_SESSION['token'])) {
				//armazenando o token
				$token = $_SESSION['token'];

				
				$user = $this->dao->findByToken($token);

				//verificando se existe o usuario se existir retorna ele msm
				if ($user) {
					return $user;
				}


			}//empty

			header("Location: " . $this->base . "/login.php");
			exit;

		}//checktoken

		public function validateLogin($email, $password){
			
			$user = $this->dao->findByEmail($email);
			//verificando se existe usuario
			if ($user) {
				//verificando a senha
				if (password_verify($password, $user->password)) {
					$token = md5(time().rand(0, 9999));

					$_SESSION['token'] = $token;
					$user->token = $token;
					$this->dao->update($user);

					return true;
				}
			}//$user

			return false;
		}//validate login

		public function emailExists($email){
			return $this->dao->findByEmail($email) ? true : false ;
		}
		//registro de novo usuario para fazer login apos o cadastro necessario criar o token
		public function registerUser($name, $password, $email, $birthdate){
			

			$hash = password_hash($password, PASSWORD_DEFAULT);
			$token = md5(time().rand(0, 9999));

			$newUser = new User();
			$newUser->name = $name;
			$newUser->email = $email;
			$newUser->password = $hash;
			$newUser->birthdate = $birthdate;
			$newUser->token = $token;

			$this->dao->insert($newUser);

			$_SESSION['token'] = $token;
		}
	}//class
 ?>