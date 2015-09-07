<?php
namespace app\behaviors;

use Yii;
use yii\behaviors\AttributeBehavior;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;

class ModelBehavior extends AttributeBehavior {

    public $searchModel = '';
    public $order = 'id';
    public $orderType = SORT_ASC;
    public $thumbField = 'thumb';

    public function getDataProvider()
    {
        if(!empty($this->searchModel))
        {
            $searchModel = new $this->searchModel();
            return $searchModel->search(Yii::$app->request->queryParams);
        }
        else {
            return new ActiveDataProvider([
                'query' => $this->owner->find(),
                'sort'  => ['defaultOrder' => [$this->order => $this->orderType]]
            ]);
        }
    }

    public function getSearchModel()
    {
        if(!empty($this->searchModel))
        {
            return new $this->searchModel();
        }
    }

    public function updateItem()
    {
        if ($this->owner->load(Yii::$app->request->post()) && $this->owner->save()) {
           Yii::$app->getSession()->setFlash('success', Yii::t('yii','Save'));
           return true;
        }
        else
        {
//            print_r($this->owner);
            return false;
        }

    }
}