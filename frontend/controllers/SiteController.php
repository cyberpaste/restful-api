<?php

namespace frontend\controllers;

use Yii;
use common\base\FrontController;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends FrontController {

    public function actions() {
        return [
            'index' => [
                'class' => 'light\swagger\SwaggerAction',
                'restUrl' => '/swagger.yaml',
            ]
        ];
    }

    public function actionError() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['error' => '404'];
    }

    public function actionSwaggerYaml() {
        $json = file_get_contents('swagger.tpl.yaml');
        $json = str_replace('((host))', $_SERVER['HTTP_HOST'], $json);
        return $json;
    }

}
