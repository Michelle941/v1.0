<?php $link = Yii::$app->params['domen'].'/site/ticket/?hash='.$ticket->hash; ?>
<div>
    <p>Yay! We can't wait to party with you.</p><br>
    <p>Here is the link to your ticket for <?php echo $party['title']?></p>
    <p><a href="<?php echo $link?>" target="_blank"><?php echo $link?></a></p><br><br><br>

    <p>Love</p>
    <p>941SocialClub</p>
</div>