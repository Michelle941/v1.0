<?php
namespace app\behaviors;

use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;

class TimeBehavior extends AttributeBehavior
{
    public $dateTimeFields;
    public $format = 'Y-m-d H:i:s';

    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_FIND => 'convertDate',
            ActiveRecord::EVENT_BEFORE_VALIDATE => 'convertDateToDB',
        ];
    }

    public function convertDate()
    {
        $this->owner->{$this->dateTimeFields} = date($this->format, $this->owner->{$this->dateTimeFields});
    }

    public function convertDateToDB()
    {
        $this->owner->{$this->dateTimeFields} = strtotime($this->owner->{$this->dateTimeFields});
    }
}