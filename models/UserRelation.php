<?php 

	class UserRelation{
		public $id;
		public $user_from;
		public $User_to; //text ou foto
	
		
	}


	interface UserRelationDao{
		
		public function insert(UserRelation $u);
		//pegando as relaçoes do usuario
		public function getRelationFrom($id);
	}
 ?>