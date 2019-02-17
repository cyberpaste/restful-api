<?php

namespace common\helpers;

use common\models\Devices;

class DeviceHelper {

    CONST DEVICES = [
        '1' => 'Модем для подключения к внешним счётчикам',
        '2' => 'Самостоятельный прибор',
    ];

    public static function validate($id) {
        if (self::DEVICES[$id]) {
            return true;
        }
        return false;
    }

    public static function getByDeviceId($id) {
        return Devices::find()->where(['device_id' => hexdec($id)])->one();
    }

}
