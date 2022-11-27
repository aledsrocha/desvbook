<?php 
	require_once 'config.php';
	require_once 'models/Auth.php';
	require_once 'dao/postDaoMysql.php';
	
	

	$auth = new Auth($pdo, $base);

	//armazenando a info do user
	$userInfo = $auth->checktoken();
	//verificando qual menu ta ativo
	$activeMenu = 'perfil';

	$id = filter_input(INPUT_GET, 'id');
	//verificando se e meu id
	if (!$id) {
		$id = $userInfo->id;
	}

	if($id != $userInfo->id){
		$activeMenu = '';
	}

	$postDao = new PostDaoMysql($pdo);
	$userDao = new UserDaoMysql($pdo);

	//pegar informações do usuario
	$user = $userDao->findById($id, true);

	if (!$user) {
		header("Location:" .$base);
		exit;
	}

	$datefrom = new DateTime($user->birthdate);
	$dateTo = new DateTime('today');
	$user->ageYears = $datefrom->diff($dateTo)->y;


	//pegar o feed deste usuario

	$feed = $postDao->getUserFeed($id);
	//verificar se eu sigo esse usuario
	
	/*
	$postDao = new PostDaoMysql($pdo);
	//pegando o feed do user logado
	$feed = $postDao->getHomeFeed($userInfo->id);
	*/

	require_once 'partials/header.php';
	require_once 'partials/menu.php';

 ?>
  <section class="feed">

 <div class="row">
  <div class="box flex-1 border-top-flat">
 <div class="box-body">
     <div class="profile-cover" style="background-image: url('<?=$base?>/media/covers/<?=$user->cover?>');"></div>
          <div class="profile-info m-20 row">
          <div class="profile-info-avatar">
          <img src="<?=$base?>/media/avatars/<?=$user->avatar?>" />
                            </div>
                            <div class="profile-info-name">
                                <div class="profile-info-name-text"><?=$user->name?></div>
                                <?php if(!empty($user->city)): ?>
                                <div class="profile-info-location"><?=$user->city?></div>
                            <?php endif ?>
                            </div>
                            <div class="profile-info-data row">
                                <div class="profile-info-item m-width-20">
                                    <div class="profile-info-item-n"><?=count($user->follorwers);?></div>
                                    <div class="profile-info-item-s">Seguidores</div>
                                </div>
                                <div class="profile-info-item m-width-20">
                                    <div class="profile-info-item-n"><?=count($user->following);?></div>
                                    <div class="profile-info-item-s">Seguindo</div>
                                </div>
                                <div class="profile-info-item m-width-20">
                                    <div class="profile-info-item-n"><?=count($user->fotos);?></div>
                                    <div class="profile-info-item-s">Fotos</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">

                <div class="column side pr-5">
                    
                    <div class="box">
                        <div class="box-body">
                            
                            <div class="user-info-mini">
                                <img src="<?=$base?>/assets/images/calendar.png" />
                                <?=date('d/m/Y', strtotime($user->birthdate));?> (<?=$user->ageYears;?> anos)
                            </div>
                            <?php if(!empty($user->city)): ?>
                            <div class="user-info-mini">
                                <img src="<?=$base;?>/assets/images/pin.png" />
                               <?=$user->city;?>
                            </div>
                             <?php endif ?>

                             <?php if(!empty($user->work)): ?>
                            <div class="user-info-mini">
                                <img src="<?=$base;?>/assets/images/work.png" />
                               <?=$user->work;?>
                            </div>
                            <?php endif ?>

                        </div>
                    </div>

                    <div class="box">
                        <div class="box-header m-10">
                            <div class="box-header-text">
                                Seguindo
                                <span><?=count($user->following);?></span>
                            </div>
                            <div class="box-header-buttons">
                                <a href="<?=$base;?>/amigos.php?id=<?=$user->id?>">ver todos</a>
                            </div>
                        </div>
                        <div class="box-body friend-list">

                        	<?php if(count($user->following) > 0 ): ?>

                        		<?php foreach($user->following as $item): ?>

                        			  <div class="friend-icon">
                              		  <a href="<?=$base;?>/perfil.php?id=<?=$item->id;?>">
                                    <div class="friend-icon-avatar">
                                        <img src="<?=$base;?>/media/avatars/<?=$item->avatar;?>" />
                                    </div>
                                    <div class="friend-icon-name">
                                       <?=$item->name;?>
                                    </div>
                                </a>
                            </div>

                        		<?php endforeach;?>


                        	<?php endif; ?>
                          

                        </div>
                    </div>

                </div>
                <div class="column pl-5">

                    <div class="box">
                        <div class="box-header m-10">
                            <div class="box-header-text">
                                Fotos
                                <span><?=count($user->fotos);?></span>
                            </div>
                            <div class="box-header-buttons">
                                <a href="<?=$base;?>/fotos.php?id=<?=$user->id;?>">ver todos</a>
                            </div>
                        </div>
                        <div class="box-body row m-20">
                            <?php if(count($user->fotos)> 0): ?>
                            <?php foreach($user->fotos as $item): ?>
                            	<div class="user-photo-item">
                                <a href="#modal-1" rel="modal:open">
                                    <img src="media/uploads/1.jpg" />
                                </a>
                                <div id="modal-1" style="display:none">
                                    <img src="media/uploads/1.jpg" />
                                </div>
                            </div>

                            <?php endforeach; ?>
                            <?php endif; ?>
                            

           
                        </div>
                    </div>

                    <?php if($id == $userInfo->id): ?>
                    	<?php require_once 'partials/feed-editor.php';?>
                    <?php endif;?>

                    <!-- o $item tem que ser assim por causa do feed-item -->
                    <?php if(count($feed) > 0 ): ?>
                    	<?php foreach($feed as $item): ?>
                    		<?php require_once 'partials/feed-item.php' ?>;
                    	<?php endforeach;?>

                    <?php else: ?>
                    Não ha postagem desse usuario.
                    <?php endif;?>

                </div>
                
            </div>

        </section>

 <?php
 require_once 'partials/footer.php';
?>