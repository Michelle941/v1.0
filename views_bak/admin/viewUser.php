<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use developeruz\yii2_user\models\User;

$this->title = 'View user';
$this->params['breadcrumbs'][] = ['label' => 'Members', 'url' => ['user']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="links-create">

    <h1><?= $model->name.' '.$model->last_name; ?></h1>

    <div class="links-form">

        <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'name',
                    'last_name',
                    'email:email',
                    'dob:date',
                    'gender',
                    'rank',
                    'relation_status',
                    'tag_line',
                    'zip_code',
                    'city',
                    'region',
                    'state',
                    'premium_status',
                    'premium_type',
                    'premium_start_date',
                    'premium_end_date',
                    'work',
                    'love'
                ],
            ]) ?>

    </div>

</div>
