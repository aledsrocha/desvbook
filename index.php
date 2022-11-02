<?php 
	require_once 'config.php';
	require_once 'models/Auth.php';
	require_once 'dao/postDaoMysql.php';
	

	$auth = new Auth($pdo, $base);

	//armazenando a info do user
	$userInfo = $auth->checktoken();
	//verificando qual menu ta ativo
	$activeMenu = 'perfil';
	

	$postDao = new PostDaoMysql($pdo);
	//pegando o feed do user logado
	$feed = $postDao->getHomeFeed($userInfo->id);

	require_once 'partials/header.php';
	require_once 'partials/menu.php';


 ?>

<section class="feed mt-10">
	<div class="row">
		<div class="column pr-5">


 <?php
 require_once 'partials/feed-editor.php';?>

<!-- repetindo o feed -->
 <?php foreach ($feed as $item):?>
  <?php require_once 'partials/feed-item.php';?>
<?php endforeach;?>



		</div>

		<div class="column side pl-5">
			  <div class="box banners">
                        <div class="box-header">
                            <div class="box-header-text">Patrocinios</div>
                            <div class="box-header-buttons">
                                
                            </div>
                        </div>
                        <div class="box-body">
                            <a href=""><img src="https://alunos.b7web.com.br/media/courses/php-nivel-1.jpg" /></a>
                            <a href=""><img src="https://alunos.b7web.com.br/media/courses/laravel-nivel-1.jpg" /></a>
                        </div>
                    </div>
                    <div class="box">
                        <div class="box-body m-10">
                            Criado com ❤️ por Alessandro
                        </div>
 </div>
		</div>
	</div>
	</section>



 <?php
 require_once 'partials/footer.php';
?>