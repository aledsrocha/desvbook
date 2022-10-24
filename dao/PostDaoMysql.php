<?php
require_once 'models/Post.php';

	class PostDaoMysql implements PostDao{
		private $pdo;

		public function __construct(PDO $driver){
			$this->pdo = $driver;
		}

		public function insert(Post $p){

			$sql = $this->pdo->prepare("INSERT INTO posts(
				id_user, type, create_at, body
		) VALUES (
		:id_user, :type, :create_at, :body
		)");

			$sql->bindValue(':id_user', $p->id_user);
			$sql->bindValue(':type', $p->type);
			$sql->bindValue(':create_at', $p->create_at);
			$sql->bindValue(':body', $p->body);
			$sql->execute();
		}
	}//class