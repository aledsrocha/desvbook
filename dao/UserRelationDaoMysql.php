<?php
require_once 'models/UserRelation.php';

	class UserRelationDaoMysql implements UserRelationDao{
		private $pdo;

		public function __construct(PDO $driver){
			$this->pdo = $driver;
		}

		public function insert(UserRelation $u){

		}
		//pegando as relaçoes do usuario
		public function getRelationFrom($id){
			$user = [$id];
			//pegando somente 1 dado da tabela
			$sql = $this->pdo->prepare("SELECT user_to FROM userrelations WHERE user_from = :user_from");
			$sql->bindValue(':user_from', $id);
			$sql->execute();

			//verificandos e achou algo
			if ($sql->rowCount() > 0) {
				$data = $sql->fetchAll();

				foreach ($data as $item) {
					$user = $item['user_to'];
				}
			}
			return $user;
		}
}