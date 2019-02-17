<?php

use yii\db\Migration;

/**
 * Class m190217_150326_add_measures_table
 */
class m190217_150326_add_measures_table extends Migration {

    public function safeUp() {
        $this->createTable('{{%measures}}', [
            'id' => $this->primaryKey(),
            'channel_id' => $this->integer(),
            'value' => $this->float(),
            'added' => $this->integer(),
        ]);
    }

    public function safeDown() {
        $this->dropTable('{{%measures}}');
    }

}
