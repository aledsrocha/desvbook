<?php 
	require_once 'config.php';
	require_once 'models/Auth.php';
	require_once 'dao/postDaoMysql.php';
	
	

	$auth = new Auth($pdo, $base);

	//armazenando a info do user
	$userInfo = $auth->checktoken();
	//verificando qual menu ta ativo
	$activeMenu = 'amigos';

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
            
          <div class="column">
                    
                    <div class="box">
                        <div class="box-body">

                            <div class="tabs">
                                <div class="tab-item" data-for="followers">
                                    Seguidores
                                </div>
                                <div class="tab-item active" data-for="following">
                                    Seguindo
                                </div>
                            </div>
                            <div class="tab-content">
                                <div class="tab-body" data-item="followers">
                                    
                                    <div class="full-friend-list">

                                        <?php foreach($user->follorwers as $item): ?>

                                        <div class="friend-icon">
                                            <a href="">
                                                <div class="friend-icon-avatar">
                                                    <img src="media/avatars/avatar.jpg" />
                                                </div>
                                                <div class="friend-icon-name">
                                                    <?=$item->name?>
                                                </div>
                                            </a>
                                        </div>


                                        <?php endforeach; ?>


                                </div>
                            </div>
                                <div class="tab-body" data-item="following">
                                    
                                    <div class="full-friend-list">
                                       <?php foreach($user->following as $item): ?>

                                        <div class="friend-icon">
                                            <a href="">
                                                <div class="friend-icon-avatar">
                                                    <img src="media/avatars/avatar.jpg" />
                                                </div>
                                                <div class="friend-icon-name">
                                                    <?=$item->name?>
                                                </div>
                                            </a>
                                        </div>


                                        <?php endforeach; ?>
                                       
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
     </div>
            </div>

        </section>

 <?php
 require_once 'partials/footer.php';
?>