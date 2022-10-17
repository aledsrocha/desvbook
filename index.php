<?php 
	require_once 'config.php';
	require_once 'models/Auth.php';

	$auth = new Auth($pdo, $base);

	//armazenando a info do user
	$userInfo = $auth->checktoken();
	

	require_once 'partials/header.php';
 ?>

 <section class="container main">

 </section>

 <?php
 require_once 'partials/footer.php';
?>