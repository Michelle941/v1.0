<?php
use yii\helpers\Html;
use app\models\Party;

$this->title = 'Party manage';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pages-index">

    <p>
        <?= Html::a('Add new party', ['add-party'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= $this->render('_partyGrid', [
            'dataProvider' => $dataProvider,
        ]) ?>

</div>