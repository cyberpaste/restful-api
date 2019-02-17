<?php

namespace frontend\modules\devices\controllers;

use common\base\FrontController;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii;
use yii\web\HttpException;
use common\base\RestController;
use common\models\Devices;

class DefaultController extends RestController {

    public $modelClass = 'common\models\Devices';

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

    public function actions() {
        $actions = parent::actions();
        return $actions;
    }

    protected function verbs() {
        return [
            'create' => ['POST'],
            'update' => ['PUT', 'PATCH', 'POST'],
            'delete' => ['DELETE'],
            'view' => ['GET'],
            'index' => ['GET'],
        ];
    }

    public function actionCreate() {
        $model = new Devices;
        $model->load(Yii::$app->request->post(), '');
        $model->save();
        if (!$model->getErrors()) {
            return $model;
        } else {
            return [
                'errors' => $model->getErrors()
            ];
        }
    }

    public function runAction($id, $params = array()) {
        if ($id == 'view' || $id == 'update' || $id == 'delete') {
            $params['id'] = hexdec($params['id']);
        }
        return parent::runAction($id, $params);
    }

}
