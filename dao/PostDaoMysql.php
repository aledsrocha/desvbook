<?php
require_once 'models/Post.php';
require_once 'dao/UserRelationDaoMysql.php';
require_once 'dao/UserDaoMysql.php';

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

		public function getHomeFeed($id_user){
			$array = [];
			//1 pega as lista dos usuarios que eu sigo
			$urDao = new UserRelationDaoMysql($this->pdo);
			//pegando a lista completa
			$userList = $urDao->getRelationFrom($id_user);
			$userList[] = $id_user; 
	
			//2pegar os post ordenado pela data

			//pegando a lista de usuario em array e fazendo sair em lista
			$sql = $this->pdo->query("SELECT * FROM posts
				WHERE id_user IN (".implode(',' , $userList).")
				ORDER BY create_at DESC");

			if ($sql->rowCount() > 0) {
				$data = $sql->fetchAll(PDO::FETCH_ASSOC);

				//3 transformar o resultado em objetos.
				$array = $this->_postListToObject($data, $id_user);
			}

			
			return $array;
		}
		//pequena função auxiliar para  retornar array em objeto do tipo post
		private function _postListToObject($postList, $id_user){
			$posts = [];
			$userDao = new UserDaoMysql($this->pdo);

			//instanciou o objeto
			foreach ($postList as $post_item) {
				$newPost = new Post();
				$newPost->id = $post_item['id'];
				$newPost->type = $post_item['type'];
				$newPost->create_at = $post_item['create_at'];
				$newPost->body = $post_item['body'];
				//se o post nao e meu
				$newPost->mine = false;

				//verificando se o post e o do msm usuario logado
				if ($post_item['id_user'] == $id_user) {
					$newPost->mine = true;
				}


				//pegar as informações do usuario e um objeto de user
				$newPost->user = $userDao->findById($post_item['id_user']);

				//informações sobre like
				$newPost->likeCount = 0;
				$newPost->liked = false;


				//informações sobre coment
				$newPost->comments = [];

				//inserindo dentro do array
				$post[] = $newPost;
			}

			return $post;

		}

	}//class