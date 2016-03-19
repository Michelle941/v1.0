<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Pages */

$this->title = 'New Page';
$this->params['breadcrumbs'][] = ['label' => 'Manage content page', 'url' => ['pages']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pages-create">

    <?= $this->render('_page_form', [
        'model' => $model,
    ]) ?>

</div>
