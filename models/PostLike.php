<?php  

	class PostLike{
		public $id;
		public $id_post;
		public $id_user;
		public $created_at;
	}

	interface PostLikeDao{

		//pegar quantidade de like do post
		public function getLikeCount($id_post);
		//ve se usuario deu like nele
		public function isLiked($id_post, $id_user);
		//se ja tem like ele tira se nao tem ele da
		public function likeTogger($id_post, $id_user);
	}

?>