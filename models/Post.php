<?php 

	class Post{
		public $id;
		public $id_user;
		public $type; //text ou foto
		public $create_at;
		public $birthdate;
		public $body;
		
	}


	interface PostDao{
		
		public function insert(Post $p);
		public function getHomeFeed($id_user);
		public function getUserFeed($id_user);
	}
 ?>