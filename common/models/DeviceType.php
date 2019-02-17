<?php

namespace common\models;

use common\base\ActiveRecord;

class DeviceType extends ActiveRecord {

    public static function tableName() {
        return '{{%device_type}}';
    }

}
