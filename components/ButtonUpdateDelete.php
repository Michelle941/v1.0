<?php
namespace app\components;

use yii\grid\ActionColumn;
use Yii;
use yii\helpers\Html;
use yii\helpers\Url;

class ButtonUpdateDelete extends ActionColumn{

    public $template = '{update} {delete}';
    public $updateAction, $deleteAction;

    protected function initDefaultButtons()
    {
        if (!isset($this->buttons['update'])) {
            $this->buttons['update'] = function ($url, $model) {
                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', Url::toRoute([$this->updateAction, 'id' => $model->id]), [
                    'title' => Yii::t('yii', 'Update'),
                    'data-pjax' => '0',
                ]);
            };
        }
        if (!isset($this->buttons['delete'])) {
            $this->buttons['delete'] = function ($url, $model) {
                return Html::a('<span class="glyphicon glyphicon-trash"></span>', Url::toRoute([$this->deleteAction,'id' => $model->id]), [
                    'title' => Yii::t('yii', 'Delete'),
                    'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                    'data-method' => 'post',
                    'data-pjax' => '0',
                ]);
            };
        }
    }

    public static function initButtonForDetailView($model, $updateUrl, $deleteUrl)
    {
       return Html::a('<span class="glyphicon glyphicon-pencil"></span>', Url::toRoute([$updateUrl, 'id' => $model->id]), [
                'title' => Yii::t('yii', 'Update'),
                'data-pjax' => '0',
                'data-toggle' => 'modal'
            ]).
       '&nbsp;&nbsp;&nbsp;&nbsp;'.
            Html::a('<span class="glyphicon glyphicon-trash"></span>', Url::toRoute([$deleteUrl,'id' => $model->id]), [
                'title' => Yii::t('yii', 'Delete'),
                'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                'data-method' => 'post',
                'data-pjax' => '0',
            ]);
    }
} 