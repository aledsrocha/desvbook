<?php 
	require_once 'config.php';
	require_once 'models/Auth.php';
	require_once 'dao/userDaoMysql.php';
	

	$auth = new Auth($pdo, $base);

	//armazenando a info do user
	$userInfo = $auth->checktoken();
	$userDao = new userDaoMysql($pdo);
	


	$name = filter_input(INPUT_POST, 'name');
	$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
	$birthdate = filter_input(INPUT_POST, 'birthdate');
	$city = filter_input(INPUT_POST, 'city');
	$work = filter_input(INPUT_POST, 'work');
	$password = filter_input(INPUT_POST, 'password');
	$password_confirmation = filter_input(INPUT_POST, 'password_confirmation');


	if ($name && $email) {
		$userInfo->name = $name;
		$userInfo->city = $city;
		$userInfo->work = $work;
		//EMAIL
		if ($userInfo->email != $email) {

			if ($userDao->findByEmail($email) === false) {
				$userInfo->email = $email;
				

			}else{
				$_SESSION['flash'] = 'Email já existe!';
				header("Location:".$base . "/configuracoes.php");
				exit;
			}//else
		}//userinfo email

		//BIRTHDATE
		$birthdate = explode('/', $birthdate);

		//fazendo a verificação se existe 3 itens no array
		if (count($birthdate) != 3) {
			$_SESSION['flash'] = 'Data de nascimento Invalida';
			header("Location:" .$base . "/configuracoes.php");
			exit;
		}

		//verificando se a data de nascimento e real primeiro o ano segundo o mes e o terceiro dia
		$birthdate = $birthdate[2]. '-'. $birthdate[1]. '-'. $birthdate[0];

		if (strtotime($birthdate) === false) {
			$_SESSION['flash'] = 'Data de nascimento Invalida';
			header("Location:" .$base . "/configuracoes.php");
			exit;
		}

		$userInfo->birthdate = $birthdate;

		//PASSWORD
		if (!empty($password)) {
			if ($password === $password_confirmation) {
				$hash = password_hash($password, PASSWORD_DEFAULT);
				$userinfo->password = $hash;
			}else{
				$_SESSION['flash'] = 'Senhas diferente digite novamente!';
				header("Location:" .$base . "/configuracoes.php");
			exit;
			}
		}
		echo "<pre>";
		print_r($_FILES);
		exit;

		//AVATAR
		//verificando se tem erro na imagem
		if (isset($_FILES['avatar']) && !empty($_FILES['avatar']['tmp_name'])) {
			$newAvatar = $_FILES['avatar'];
			//colocando tipo de imagem aceitavel
			if (in_array($newAvatar['type'], ['image/jpeg', 'image/jpg', 'image/png'])) {
				//tamanho da imagem
				$avatarWidth = 200;
				$avatarHeight = 200;

				list($widthOrigi, $heightOrigi) = getimagesize($newAvatar['tmp_name']);

				$ratio = $widthOrigi / $heightOrigi;

				$newWidith = $avatarWidth;
				$newHeight = $newWidith / $ratio;

				//caso o tamanho nao fique certo
				if ($newHeight < $avatarHeight) {
					$newHeight = $avatarHeight;
					$newWidith = $newHeight * $ratio;
				}
				$x = $avatarWidth - $newWidith;
				$y = $avatarHeight - $newHeight;
				$x = $x<0 ? $x/2 : $x;
				$y = $y<0 ? $y/2 : $y;

				//pegando a imagem final
				$finalImage = imagecreatetruecolor($avatarWidth, $avatarHeight);

				switch ($newAvatar['type']) {
					case 'image/jpeg';
					case 'image/jpg';
					$image = imagecreatefromjpeg($newAvatar['tmp_name']);
					break;

					

					case 'image/png';
					$image = imagecreatefrompng($newAvatar['tmp_name']);					
					break;
				}
				//copiando a imagem dentro da outra
				imagecopyresampled(
					$finalImage, $image,
					$x, $y, 0,0,
					$newWidith, $newHeight, $widthOrigi, $heightOrigi
				);
				imagejpeg($finalImage, '/teste.jpeg', 100);
			}
		}
		exit;

		//fazendo o update dos dados depois de ter feito todo processo
		$userDao->update($userInfo);
	}//name && $email

	header("Location:".$base . "/configuracoes.php");
	exit;
 ?>