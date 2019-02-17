<?php

namespace common\models;

use common\base\ActiveRecord;
use common\models\DeviceType;
use yii\behaviors\AttributesBehavior;
use common\helpers\DeviceHelper;

class Devices extends ActiveRecord {

    public static function tableName() {
        return '{{%devices}}';
    }

    public function behaviors() {
        return [
            [
                'class' => AttributesBehavior::className(),
                'attributes' => [
                    'device_id' => [
                        ActiveRecord::EVENT_BEFORE_UPDATE => function ($event, $attribute) {
                            $model = $event->sender;
                            if ($this->$attribute !== $model->getOldAttribute($attribute)) {
                                $event->isValid = false;
                                $this->addError($attribute, 'device_id change.');
                            }
                            return $this->$attribute;
                        },
                        ActiveRecord::EVENT_AFTER_FIND => function ($event, $attribute) {
                            return dechex($this->$attribute);
                        },
                        ActiveRecord::EVENT_BEFORE_INSERT => function ($event, $attribute) {
                            if (static::find()->where(['device_id' => hexdec($this->$attribute)])->one()) {
                                $event->isValid = false;
                                $this->addError($attribute, 'device_id duplicate.');
                            }
                            return hexdec($this->$attribute);
                        },
                    ],
                    'type_id' => [
                        ActiveRecord::EVENT_BEFORE_UPDATE => function ($event, $attribute) {
                            $model = $event->sender;
                            if ($this->$attribute !== $model->getOldAttribute($attribute)) {
                                $event->isValid = false;
                            }
                            return $this->$attribute;
                        },
                        ActiveRecord::EVENT_BEFORE_INSERT => function ($event, $attribute) {
                            if (!DeviceHelper::validate($this->$attribute)) {
                                $event->isValid = false;
                                $this->addError($attribute, 'device_type unknown');
                            }
                            return $this->$attribute;
                        },
                    ],
                ],
            ],
        ];
    }

    public function rules() {
        return [
            [['device_id', 'type_id'], 'required'],
            ['device_id', 'string'],
            ['device_id', 'unique'],
            ['type_id', 'integer'],
            ['imei', 'string', 'max' => 16],
            ['install_location', 'string', 'max' => 255],
        ];
    }

    public function update($runValidation = true, $attributeNames = null) {
        parent::update($runValidation, $attributeNames);
    }

}
