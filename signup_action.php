<?php 
	require_once 'config.php';
	require_once 'models/Auth.php';

	$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
	$password = filter_input(INPUT_POST, 'password');
	$name = filter_input( INPUT_POST, 'name');
	$birthdate = filter_input( INPUT_POST, 'birthdate'); // 00/00/0000


	if ($email && $password && $name && $birthdate) {
		$auth = new Auth($pdo, $base);

		$birthdate = explode('/', $birthdate);

		//fazendo a verificação se existe 3 itens no array
		if (count($birthdate) != 3) {
			$_SESSION['flash'] = 'Data de nascimento Invalida';
			header("Location:" .$base . "/signup.php");
			exit;
		}

		//verificando se a data de nascimento e real primeiro o ano segundo o mes e o terceiro dia
		$birthdate = $birthdate[2]. '-'. $birthdate[1]. '-'. $birthdate[0];

		if (strtotime($birthdate) === false) {
			$_SESSION['flash'] = 'Data de nascimento Invalida';
			header("Location:" .$base . "/signup.php");
			exit;
		}

		//verificando se existe email
		if ($auth->emailExists($email) === false) {
			
			$auth->registerUser($name, $password, $email, $birthdate);
			header("Location:" .$base);
			exit;
		}else{
			$_SESSION['flash'] = 'Email ja cadastrado';
			header("Location:" .$base . "/signup.php");
			exit;
		}
	
	}

	$_SESSION['flash'] = 'campos não enviados';
	header("Location:" .$base . "/signup.php");
	exit;
 ?>