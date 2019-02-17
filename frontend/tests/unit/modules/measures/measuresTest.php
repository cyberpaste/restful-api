<?php

namespace frontend\tests\modules\measures;

use common\models\Measures;
use common\helpers\MeasureHelper;

class measuresTest extends \Codeception\Test\Unit {

    /**
     * @var \frontend\tests\UnitTester
     */
    protected $tester;

    protected function _before() {
        
    }

    protected function _after() {
        
    }

    public function testCreate() {
        $testData = [
            'channel_id' => 1,
            'value' => 3.4,
            'added' => 1550409618
        ];
        $measure = Measures::find()->where($testData)->one();
        if ($measure) {
            $measure->delete();
        }
        $model = new Measures;
        $model->setAttributes($testData);
        $model->save();
        $this->assertEmpty($model->getErrors());
    }

    /**
     * Add Unknown channel id
     */
    public function testBadCreate() {
        $testData = [
            'channel_id' => 4444,
            'value' => 3.4,
            'added' => 1550409618
        ];
        $measure = Measures::find()->where($testData)->one();
        if ($measure) {
            $measure->delete();
        }
        $model = new Measures;
        $model->setAttributes($testData);
        $model->save();
        $this->assertNotEmpty($model->getErrors());
    }

}
