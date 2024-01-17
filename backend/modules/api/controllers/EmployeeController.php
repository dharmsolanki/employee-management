<?php

namespace backend\modules\api\controllers;

use backend\modules\api\models\User;
use Yii;

class EmployeeController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;

    public function actionIndex()
    {
        echo '<pre>';
        print_r('this is test');
        exit();
        return $this->render('index');
    }

    public function actionCreateEmployee()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON; //this will return response in json

        $employee = new User();
        $employee->scenario = User::SCENARIO_CREATE;
        $employee->attributes = Yii::$app->request->post();

        if ($employee->validate()) {
            return ['status' => true];
        } else {
            return ['status' => false,'data' => $employee->getErrors()];
        }
    }
}
