<?php

use yii\db\Migration;

/**
 * Class m190217_150412_add_indexes
 */
class m190217_150412_add_indexes extends Migration {

    public function safeUp() {
        $this->createIndex(
                'idx-channels-device_id', '{{%channels}}', 'device_id'
        );
        $this->createIndex(
                'idx-measureres_channel_id', '{{%measures}}', 'channel_id'
        );
    }

    public function safeDown() {
        $this->dropIndex('idx-channels-device_id', '{{%channels}}');
        $this->dropIndex('idx-measureres_channel_id', '{{%measures}}');
    }

}
