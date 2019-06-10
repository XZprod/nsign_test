<?php

namespace frontend\controllers;

use common\models\ProductSearch;
use Yii;
use yii\web\Controller;

/**
 * Site controller
 */
class SiteController extends Controller
{

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        $productsDataProvider = ProductSearch::search(Yii::$app->request->get('ProductSearch'));
        $filterModel = new ProductSearch(Yii::$app->request->get('ProductSearch'));
        return $this->render('index', [
            'dataProvider' => $productsDataProvider,
            'filterModel' => $filterModel
        ]);
    }

}
