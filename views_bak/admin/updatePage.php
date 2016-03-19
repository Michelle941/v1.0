<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Pages */

$this->title = 'Edit page: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Manage content page', 'url' => ['pages']];
$this->params['breadcrumbs'][] = 'Edit page ';
?>
<div class="pages-update">

    <?= $this->render('_page_form', [
        'model' => $model,
    ]) ?>

</div>
