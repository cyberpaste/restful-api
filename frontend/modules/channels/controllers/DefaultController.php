<?php

namespace frontend\modules\channels\controllers;

use yii\filters\AccessControl;
use yii;
use common\base\RestController;

class DefaultController extends RestController {

    public $modelClass = 'common\models\Channels';

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
        ];
    }

    protected function verbs() {
        return [
            'create' => ['POST'],
            'update' => ['PUT', 'PATCH', 'POST'],
            'delete' => ['DELETE'],
            'view' => ['GET'],
            'index' => ['GET'],
            'device' => ['GET'],
        ];
    }

    /**
     * TODO Fixme
     * @param type $id
     * @return type
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionDevice($id) {
        $connection = Yii::$app->getDb();
        $conditionParams = [];
        $params = [];
        $sql = "SELECT measures.channel_id, device_id, measure_unit, measure_item, value, added
             FROM channels
            LEFT JOIN measures 
             ON channels.id= measures.channel_id
             WHERE measures.added = (
              SELECT MAX(added)
              FROM measures
              WHERE measures.channel_id = channels.id
            )
            HAVING channels.device_id = :device_id";
        $conditionParams['device_id'] = $id;
        $command = $connection->createCommand($sql, array_merge($conditionParams, $params));
        $queryResult = $command->queryAll();
        if ($queryResult) {
            foreach ($queryResult as $i => $item) {
                $queryResult[$i]['device_id'] = dechex($item['device_id']);
            }
        } else {
            throw new \yii\web\NotFoundHttpException;
        }
        return $queryResult;
    }

    public function runAction($id, $params = array()) {
        if ($id == 'device') {
            $params['id'] = hexdec($params['id']);
        }
        return parent::runAction($id, $params);
    }

}
