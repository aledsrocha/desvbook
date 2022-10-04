<?php 
	require_once 'models/User.php';
	class UserDaoMysql implements UserDao{

		//pdo para fazer as consultas
		private $pdo; 
		public function __construct($pdo){
			$this->pdo = $driver;
		}//construct


		public function findByToken($token){

		}//findby token
	}//class
 ?>