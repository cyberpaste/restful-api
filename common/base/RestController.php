<?php

namespace common\base;

use yii\rest\ActiveController;
use yii;
use yii\web\Response;

abstract class RestController extends ActiveController {

    public function beforeAction($action) {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return parent::beforeAction($action);
    }

}
