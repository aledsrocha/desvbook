<?php
	//todos os arquivos ligado ao feed-item-script
	require_once 'config.php';
	require_once 'models/Auth.php';
	require_once 'dao/PostDaoMysql.php';

	$auth = new Auth($pdo, $base);

	//armazenando a info do user
	$userInfo = $auth->checktoken();

	//tamanho maximo da imagem
	$maxWidith = 800;
	$maxHeight = 800;


	$array = ['error' => ''];

	$postDao = new PostDaoMysql($pdo);


	//verificar se recebeu alguma imagem
	//photo do arquivo feed-editor
	if (isset($_FILES['photo']) && !empty($_FILES['photo']['tmp_name'])) {
		$photo = $_FILES['photo'];
		
		//definindo os tipos de imagem aceita
		if (in_array($photo['type'],['image/jpeg','image/jpg', 'image/png'])) {

			list($widithOrigin, $heightOrigin) = getimagesize($photo['tmp_name']);
			$ratio = $widithOrigin / $heightOrigin;

			$newWidth = $maxWidith;
			$newHeight = $newWidth / $ratio;

			//se altura for maior
			if ($newHeight < $maxHeight) {
				$newHeight = $maxHeight;
				$newWidth = $newHeight * $ratio;
			}//altura maior

			$finalImage = imagecreatetruecolor($newWidth, $newHeight);
			//pegando tamanho original
			switch($photo['type']){
				case 'image/jpeg' :
				case 'image/jpg' :
				$image =imagecreatefromjpeg($photo['tmp_name']);
				break;

				case 'image/png':
				$image = imagecreatefrompng($photo['tmp_name']);
				break;
			}

			imagecopyresampled(
				$finalImage, $image,
				0, 0, 0,0,
				$newWidth, $newHeight, $widithOrigin, $heightOrigin
			);

			$photoName = md5(time().rand(0,9999)) . '.jpg';
			imagejpeg($finalImage, 'media/uploads/'. $photoName);

			$newPost = new Post();
			$newPost->id_user = $userInfo->id;
			$newPost->type = 'photo';
			$newPost->create_at = date('Y-m-d H:i:s');
			$newPost->body = $photoName;

			$postDao->insert($newPost);
			
		}else{
			$array['error'] = 'Arquivo não Suportado!';
		}

	}else{
		$array['error'] = 'Nenhuma imagem enviada';
	}



		//transformando array em json
	header("Content-Type: application/json");
	echo json_encode($array);
	exit;