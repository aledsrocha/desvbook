<?php 
 $actionFrase = '';

 switch ($item->type) {
     case 'text':
         $actionFrase = 'fez um post';
         break;
     
      case 'photo':
         $actionFrase = 'postou um foto';
         break;
     
 }
?>

    <div class="box feed-item" data-id="<?=$item->id;?>">
       <div class="box-body">
       <div class="feed-item-head row mt-20 m-width-20">
        <div class="feed-item-head-photo">
       <a href="<?=$base;?>/perfil.php?id=<?=$item->user->id;?>"><img src="<?=$base;?>/media/avatars/<?=$item->user->avatar;?>" /></a>
           </div>
      <div class="feed-item-head-info">
     <a href="<?=$base;?>/perfil.php?id=<?=$item->user->id;?>"><span class="fidi-name"><?=$item->user->name;?></span></a>
  <span class="fidi-action"><?=$actionFrase;?></span>
       <br/>
    <span class="fidi-date"><?=date('Y/m/d', strtotime($item->create_at)); ?></span>
       </div>
       <div class="feed-item-head-btn">
           <img src="<?=$base;?>/assets/images/more.png" />
          </div>
         </div>
    <div class="feed-item-body mt-10 m-width-20">
       <?=$item->body;?>
          </div>
         <div class="feed-item-buttons row mt-20 m-width-20">
           <div class="like-btn <?=$item->likeCount? 'on': '';?>"><?=$item->likeCount;?></div>
           <div class="msg-btn"><?=count($item->comments);?></div>
           </div>
           <div class="feed-item-comments">


                                <div class="fic-answer row m-height-10 m-width-20">
                                    <div class="fic-item-photo">
                                        <a href="<?=$base;?>/perfil.php"><img src="<?=$base;?>/media/avatars/<?=$userInfo->avatar;?>" /></a>
                                    </div>
                                    <input type="text" class="fic-item-field" placeholder="Escreva um comentário" />
                                </div>

                            </div>
                        </div>
                    </div>
                    
