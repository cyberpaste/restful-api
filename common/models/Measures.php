<?php

namespace common\models;

use common\base\ActiveRecord;
use common\models\DeviceType;
use yii\behaviors\AttributesBehavior;
use common\models\Channels;

class Measures extends ActiveRecord {

    public static function tableName() {
        return '{{%measures}}';
    }

    public function behaviors() {
        return [
            [
                'class' => AttributesBehavior::className(),
                'attributes' => [
                    'channel_id' => [
                        ActiveRecord::EVENT_BEFORE_INSERT => function ($event, $attribute) {
                            if (!Channels::find()->where(['id' => $this->$attribute])->one()) {
                                $event->isValid = false;
                                $this->addError($attribute, 'channel unknown.');
                            }
                            return $this->$attribute;
                        },
                    ],
                    'added' => [
                        ActiveRecord::EVENT_BEFORE_INSERT => function ($event, $attribute) {
                            if (!$this->$attribute) {
                                return time();
                            }
                            return $this->$attribute;
                        },
                    ],
                ],
            ],
        ];
    }

    function rules() {
        return [
            [['channel_id', 'value'], 'required'],
            ['channel_id', 'integer'],
            ['value', 'double'],
            ['added', 'date', 'format' => 'php:U'],
        ];
    }

}
