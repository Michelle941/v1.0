<?php
use yii\helpers\Url;

foreach($members as $m) {
    ?>
    <li class="members__item">
        <a href="<?= Url::to(['site/member', 'id' => 'qt'.$m['id']]); ?>">
            <figure class="members__photo">
                <img src="/upload/160x160_square<?= $m['avatar']; ?>" alt="" width="160" height="160">
            </figure>
            <span class="members__name"><?= $m['name']; ?></span>
        </a>
    </li>
<?php
}
?>