<?php 

	class UserRelation{
		public $id;
		public $user_from;
		public $User_to; //text ou foto
	
		
	}


	interface UserRelationDao{
		
		public function insert(UserRelation $ur);
		public function delete(UserRelation $ur);
		//pegando as relaçoes do usuario
		public function getFollowing($id);
		public function getFollowers($id);
		public function isFollowing($id1, $id2);
	}
 ?>