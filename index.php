<?php 
	require_once 'config.php';
	require_once 'models/Auth.php';

	$auth = new Auth($pdo, $base);

	//armazenando a info do user
	$userInfo = $auth->checktoken();
	//verificando qual menu ta ativo
	$activeMenu = 'perfil';
	

	require_once 'partials/header.php';
	require_once 'partials/menu.php';


 ?>

<section class="feed mt-10">
	...
</section>



 <?php
 require_once 'partials/footer.php';
?>