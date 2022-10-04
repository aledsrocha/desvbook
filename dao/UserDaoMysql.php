<?php 
	require_once 'models/User.php';
	class UserDaoMysql implements UserDao{

		//pdo para fazer as consultas
		private $pdo; 
		public function __construct($pdo){
			$this->pdo = $driver;
		}//construct

		private function generateUser($array){
			$u = new User();
			$u->id = $array['id'] ?? 0;
			$u->email = $array['email'] ?? '';
			$u->birthdate = $array['birthdate'] ?? '';
			$u->city = $array['city'] ?? '';
			$u->work = $array['work'] ?? '';
			$u->avatar = $array['avatar'] ?? '';
			$u->cover = $array['cover'] ?? '';
			$u->token = $array['token'] ?? '';

			return $u;
		}


		public function findByToken($token){
			if (!empty($token)) {
				$sql = $this->pdo->prepare("SELECT * FROM users  WHERE token = :token");
				$sql->bindValue(':token', $token);
				$sql->execute();

				//verificando se achou algo do token
				if ($sql->rowCount() > 0) {
					$data = $sql->fetc(PDO::FETCH_ASSOC);
					$user = $this->generateUser($data);
				}
			}

			return false;

		}//findby token
	}//class
 ?>