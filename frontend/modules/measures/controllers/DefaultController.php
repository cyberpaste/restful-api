<?php

namespace frontend\modules\measures\controllers;

use yii\filters\AccessControl;
use yii;
use common\base\RestController;
use common\models\Measures;

class DefaultController extends RestController {

    public $modelClass = 'common\models\Measures';

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
            'channel' => ['GET'],
        ];
    }

    public function actionChannel($id) {
        $get = Yii::$app->request->get();
        $measures = Measures::find()->where(['channel_id' => $id]);
        if ($get['limit']) {
            $measures->limit($get['limit']);
        }
        if ($get['added_from']) {
            $measures->andWhere(['>=', 'added', $get['added_from']]);
        }
        if ($get['added_to']) {
            $measures->andWhere(['<=', 'added', $get['added_to']]);
        }
        $measures->orderBy(['added' => SORT_DESC]);
        $queryResult = $measures->all();
        if (!$queryResult) {
            throw new \yii\web\NotFoundHttpException;
        }
        return $queryResult;
    }

}
