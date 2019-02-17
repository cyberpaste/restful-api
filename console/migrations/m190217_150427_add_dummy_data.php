<?php

use yii\db\Migration;
use common\models\Devices;
use common\models\Channels;
use common\helpers\MeasureHelper;

/**
 * Class m190217_150427_add_dummy_data
 */
class m190217_150427_add_dummy_data extends Migration {

    public function safeUp() {
        $locations = ['moscow test', 'spb test'];


        for ($i = 1; $i <= 22; $i++) {
            $device = new Devices;
            $device->device_id = dechex(7200000 + $i);
            $device->type_id = rand(1, 2);
            $device->imei = '123456789' . $i;
            $device->install_location = $locations[array_rand($locations, 1)];
            $device->save();
        }

        $measures = MeasureHelper::MEASURE_RELATION;

        for ($i = 1; $i <= 22; $i++) {
            $random = array_rand($measures, 1);
            $device = new Channels;
            $device->device_id = dechex(7200000 + $i);
            $device->measure_unit = $random;
            $device->measure_item = $measures[$random];
            $device->save();
        }
    }

    public function safeDown() {
        $this->delete('{{%devices}}');
        $this->delete('{{%channels}}');
    }

}
