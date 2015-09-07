<?php
use yii\helpers\Url;

foreach($shares as $share)
{
    ?>
    <li class="photo-social__item">
        <a href="<?=Url::to(['site/member', 'id' => 'qt'.$share->user_id]);?>"><img src="/upload/160x160_square<?=$share->user->avatar;?>" alt="" width="65" height="65"></a>
    </li>
<?php
}
?>