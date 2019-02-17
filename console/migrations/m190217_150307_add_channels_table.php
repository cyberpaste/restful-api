<?php

use yii\db\Migration;

/**
 * Class m190217_150307_add_channels_table
 */
class m190217_150307_add_channels_table extends Migration {

    public function safeUp() {
        $this->createTable('{{%channels}}', [
            'id' => $this->primaryKey(),
            'device_id' => $this->integer(),
            'measure_unit' => $this->string(),
            'measure_item' => $this->string(),
            'imei' => $this->string(16),
            'install_location' => $this->string(255),
        ]);
    }

    public function safeDown() {
        $this->dropTable('{{%channels}}');
    }

}
