<?php 

	require_once 'models/PostLike.php';


	class PostLikeDaoMysql implements PostLikeDao{
		private $pdo;

		public function __construct(PDO $driver){
			$this->pdo = $driver;
		}

		//pegar quantidade de like do post
		public function getLikeCount($id_post){
			$sql = $this->pdo->prepare("SELECT COUNT(*) as c FROM postlikes WHERE id_post = :id_post ");
			$sql->bindValue(':id_post', $id_post);
			$sql->execute();

			$data = $sql->fetch();
			return $data['c'];
		}

		//ve se usuario deu like nele
		public function isLiked($id_post, $id_user){
			$sql = $this->pdo->prepare("SELECT * FROM postlikes WHERE id_post = :id_post AND id_user = :id_user ");
			$sql->bindValue(':id_post', $id_post);
			$sql->bindValue(':id_user', $id_user);
			$sql->execute();

			if ($sql->rowCount() >0) {
				return true;
			}else{
				return false;
			}

		}

		//se ja tem like ele tira se nao tem ele da
		public function likeTogger($id_post, $id_user){
			if ($this->isLiked($id_post, $id_user)) {
				//delete
				$sql = $this->pdo->prepare("DELETE FROM postlikes WHERE id_post = :id_post AND id_user = :id_user");
				
			}else{
				$sql = $this->pdo->prepare("INSERT INTO postlikes (id_post, id_user, created_at) 
				VALUES ( :id_post, :id_user, NOW())");
				

			}
			$sql->bindValue(':id_post', $id_post);
			$sql->bindValue(':id_user', $id_user);
			$sql->execute();

		}//liketogger



	}//class

 ?>