<?php

use yii\db\Migration;

/**
 * Class m190217_150244_add_devices_table
 */
class m190217_150244_add_devices_table extends Migration {

    public function safeUp() {
        $this->createTable('{{%devices}}', [
            'device_id' => $this->primaryKey()->unique(),
            'type_id' => $this->integer(1),
            'imei' => $this->string(16),
            'install_location' => $this->string(255),
        ]);
    }

    public function safeDown() {
        $this->dropTable('{{%devices}}');
    }

}
