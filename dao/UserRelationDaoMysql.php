<?php
require_once 'models/UserRelation.php';

	class UserRelationDaoMysql implements UserRelationDao{
		private $pdo;

		public function __construct(PDO $driver){
			$this->pdo = $driver;
		}

		public function insert(UserRelation $ur){

		}
		//lista de usuario segue
		public function getFollowing($id){
			$users = [];
			//pegando somente 1 dado da tabela
			$sql = $this->pdo->prepare("SELECT user_to FROM userrelations WHERE user_from = :user_from");
			$sql->bindValue(':user_from', $id);
			$sql->execute();

			//verificandos e achou algo
			if ($sql->rowCount() > 0) {
				$data = $sql->fetchAll();

				foreach ($data as $item) {
					$users[] = $item['user_to'];
				}
			}
			return $users;
		}

		//lista seguido pelo usuario
		public function getFollowers($id){
			$users = [];
			//pegando somente 1 dado da tabela
			$sql = $this->pdo->prepare("SELECT user_from FROM userrelations WHERE user_to = :user_to");
			$sql->bindValue(':user_to', $id);
			$sql->execute();

			//verificandos e achou algo
			if ($sql->rowCount() > 0) {
				$data = $sql->fetchAll();

				foreach ($data as $item) {
					$users[] = $item['user_from'];
				}
			}
			return $users;
		}
}