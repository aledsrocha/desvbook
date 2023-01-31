<?php  

	class PostComment{
		public $id;
		public $id_post;
		public $id_user;
		public $created_at;
		public $body;
	}

	interface PostCommentDao{

		//pegar os comentarios
		public function getComment($id_post);
		//add os comentarios
		public function addComment(PostComment $pc);
		
	}

?>