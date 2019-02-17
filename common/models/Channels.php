<?php

namespace common\models;

use common\base\ActiveRecord;
use common\models\DeviceType;
use yii\behaviors\AttributesBehavior;
use common\models\Devices;
use common\helpers\MeasureHelper;
use common\helpers\DeviceHelper;

class Channels extends ActiveRecord {

    public $scenario;

    CONST SCENARIO_BLANK_IMEI_FIELDS = 'blank_fields';
    CONST SCENATIO_DISABLE_MEASURE_CHANGE = 'disable_measure_change';

    public static function tableName() {
        return '{{%channels}}';
    }

    public function behaviors() {
        return [
            [
                'class' => AttributesBehavior::className(),
                'attributes' => [
                    'device_id' => [
                        ActiveRecord::EVENT_BEFORE_UPDATE => function ($event, $attribute) {
                            $model = $event->sender;
                            return $model->getOldAttribute($attribute);
                        },
                        ActiveRecord::EVENT_AFTER_FIND => function ($event, $attribute) {
                            return dechex($this->$attribute);
                        },
                        ActiveRecord::EVENT_BEFORE_INSERT => function ($event, $attribute) {
                            if (!Devices::find()->where(['device_id' => hexdec($this->$attribute)])->one()) {
                                $event->isValid = false;
                                $this->addError($attribute, 'device_id unknown.');
                            }
                            return hexdec($this->$attribute);
                        },
                    ],
                    'measure_unit' => [
                        ActiveRecord::EVENT_BEFORE_UPDATE => function ($event, $attribute) {
                            $model = $event->sender;
                            if ($this->scenario == self::SCENATIO_DISABLE_MEASURE_CHANGE) {
                                if ($this->$attribute !== $model->getOldAttribute($attribute)) {
                                    return $model->getOldAttribute($attribute);
                                }
                            }
                            return $this->$attribute;
                        },
                        ActiveRecord::EVENT_BEFORE_INSERT => function ($event, $attribute) {
                            if (static::find()->where(['device_id' => $this->device_id, 'measure_unit' => $this->measure_unit])->one()) {
                                $event->isValid = false;
                                $this->addError($attribute, 'duplicate params');
                            }
                            return $this->$attribute;
                        },
                    ],
                    'measure_item' => [
                        ActiveRecord::EVENT_BEFORE_UPDATE => function ($event, $attribute) {
                            $model = $event->sender;
                            if ($this->scenario == self::SCENATIO_DISABLE_MEASURE_CHANGE) {
                                if ($this->$attribute !== $model->getOldAttribute($attribute)) {
                                    return $model->getOldAttribute($attribute);
                                }
                            }
                            if (!MeasureHelper::validate($this->measure_unit, $this->measure_item)) {
                                $event->isValid = false;
                                $this->addError($attribute, 'cannot measure ' . $this->measure_unit . ' in ' . $this->measure_item);
                            }

                            return $this->$attribute;
                        },
                        ActiveRecord::EVENT_BEFORE_INSERT => function ($event, $attribute) {
                            /* custom measure validator */
                            if (!MeasureHelper::validate($this->measure_unit, $this->measure_item)) {
                                $event->isValid = false;
                                $this->addError($attribute, 'cannot measure ' . $this->measure_unit . ' in ' . $this->measure_item);
                            }
                            return $this->$attribute;
                        },
                    ],
                    'imei' => [
                        ActiveRecord::EVENT_BEFORE_UPDATE => function ($event, $attribute) {
                            if ($this->scenario == self::SCENARIO_BLANK_IMEI_FIELDS) {
                                if ($this->$attribute) {
                                    $event->isValid = false;
                                    $this->addError($attribute, 'this value should be blank');
                                }
                            }
                            return $this->$attribute;
                        },
                        ActiveRecord::EVENT_BEFORE_INSERT => function ($event, $attribute) {
                            if ($this->scenario == self::SCENARIO_BLANK_IMEI_FIELDS) {
                                if ($this->$attribute) {
                                    $event->isValid = false;
                                    $this->addError($attribute, 'this value should be blank');
                                }
                            }
                            return $this->$attribute;
                        },
                    ],
                    'install_location' => [
                        ActiveRecord::EVENT_BEFORE_UPDATE => function ($event, $attribute) {
                            $model = $event->sender;
                            if ($this->scenario == self::SCENARIO_BLANK_IMEI_FIELDS) {
                                if ($this->$attribute) {
                                    $event->isValid = false;
                                    $this->addError($attribute, 'this value should be blank');
                                }
                            }
                            return $this->$attribute;
                        },
                        ActiveRecord::EVENT_BEFORE_INSERT => function ($event, $attribute) {
                            $model = $event->sender;
                            if ($this->scenario == self::SCENARIO_BLANK_IMEI_FIELDS) {
                                if ($this->$attribute) {
                                    $event->isValid = false;
                                    $this->addError($attribute, 'this value should be blank');
                                }
                            }
                            return $this->$attribute;
                        },
                    ],
                ],
            ],
        ];
    }

    public function scenarios() {
        return parent::scenarios();
    }

    public function beforeValidate() {
        $deviceHelper = DeviceHelper::getByDeviceId($this->device_id);
        if ($deviceHelper->type_id == '1') {
            $this->scenario = self::SCENARIO_BLANK_IMEI_FIELDS;
        } elseif ($deviceHelper->type_id == '2') {
            $this->scenario = self::SCENATIO_DISABLE_MEASURE_CHANGE;
        }
        return parent::beforeValidate();
    }

    public function rules() {
        return [
            [['device_id', 'measure_unit'], 'required'],
            ['device_id', 'string'],
            ['measure_unit', 'string'],
            ['measure_item', 'string'],
            ['imei', 'string', 'max' => 16],
            ['install_location', 'string', 'max' => 255],
        ];
    }

}
