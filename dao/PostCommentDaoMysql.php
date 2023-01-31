<?php 

	require_once 'models/PostComment.php';
	require_once 'dao/UserDaoMysql.php';


	class PostCommentDaoMysql implements PostCommentDao{
		private $pdo;

		public function __construct(PDO $driver){
			$this->pdo = $driver;
		}

		//pegar os comentarios
		public function getComment($id_post){
			$array = [];

			$sql = $this->pdo->prepare("SELECT * FROM postcoments WHERE id_post = :id_post");
			$sql->bindValue('id_post', $id_post);
			$sql->execute();

			if ($sql->rowCount() > 0) {
				$data = $sql->fetchAll(PDO::FETCH_ASSOC);
				$userDao = new UserDaoMysql($this->pdo);


				//transofrmando o objeto
				foreach ($data as $item) {
					$commentItem = new PostComment();
					$commentItem->id = $item['id'];
					$commentItem->id_post = $item['id_post'];
					$commentItem->id_user = $item['id_user'];
					$commentItem->body = $item['body'];
					$commentItem->created_at = $item['created_at'];
					//pegando todas as informações do user para exibir quem comentou
					$commentItem->user = $userDao->findById($item['id_user']);

					$array[] = $commentItem;
				}
			}
			return $array;
		}
		//add os comentarios
		public function addComment(PostComment $pc){

			$sql = $this->pdo->prepare("INSERT INTO postcoments (id_post, id_user, body, created_at)
				VALUES (:id_post, :id_user, :body, :created_at)");
			$sql->bindValue(':id_post', $pc->id_post);
			$sql->bindValue(':id_user', $pc->id_user);
			$sql->bindValue(':body', $pc->body);
			$sql->bindValue(':created_at', $pc->created_at);
			$sql->execute();
			



		}

	}//class

 ?>