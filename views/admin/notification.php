<?php
use yii\helpers\Html;
use app\models\Party;

$this->title = 'Notification manage';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pages-index">

    <p>
        <?= Html::a('Add new notification', ['add-notification'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= $this->render('_notificationGrid', [
            'dataProvider' => $dataProvider,
        ]) ?>

</div>
