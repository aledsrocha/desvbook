<?php 
	require_once 'config.php';
	require_once 'models/Auth.php';
	require_once 'dao/userDaoMysql.php';
	

	$auth = new Auth($pdo, $base);

	//armazenando a info do user
	$userInfo = $auth->checktoken();
	//verificando qual menu ta ativo
	$activeMenu = 'configuracoes';
	

	$userDao = new userDaoMysql($pdo);
	

	require_once 'partials/header.php';
	require_once 'partials/menu.php';


 ?>

<section class="feed mt-10">
	<h1>Configurações</h1>

	  <?php  if(!empty($_SESSION['flash'])): ?>
                <?=$_SESSION['flash'];?>
                <?php $_SESSION['flash'] = ''; ?>

            <?php endif; ?>
	<form method="post" class="config-form" enctype="multipart/form-data" action="configuracoes_action.php">

		<label>
			Novo avatar: <br>
			<input type="file" name="avatar" value=" <?=$userInfo->avatar?> ">
			<img src="<?=$base;?>/media/avatars/<?=$userInfo->avatar;?>">
		</label>

		<label>
			Nova capa: <br>
			<input type="file" name="cover" value=" <?=$userInfo->cover?> " >
			<img src="<?=$base;?>/media/covers/<?=$userInfo->cover;?>">
		</label>

		<label>
			nome completo: <br>
			<input type="text" name="name" value=" <?=$userInfo->name?> " >
		</label>

		<label>
			email: <br>
			<input type="email" name="email" value=" <?=$userInfo->email?> ">
		</label>

		<label>
			data de nascimento: <br>
			<input id="birthdate" type="text" name="birthdate" value=" <?=date('d/m/Y', strtotime($userInfo->birthdate));?> " >
		</label>

		<label>
			cidade: <br>
			<input type="text" name="city" value=" <?=$userInfo->city?> " >
		</label>

		<label>
			trabalho: <br>
			<input type="text" name="work" value=" <?=$userInfo->work?> " >
		</label>

		<hr/>

		<label>
			nova senha: <br>
			<input type="password" name="password">
		</label>

		<label>
			confirmar senha: <br>
			<input type="password" name="password_confirmation">
		</label>

		<button class="button">Salvar</button>


	</form>
	</section>

 <script src="https://unpkg.com/imask"></script>
    <script >
        IMask(
            document.getElementById("birthdate"),
            {mask: '00/00/0000'}
            );
    </script>

 <?php
 require_once 'partials/footer.php';
?>