<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionCreateAdmin($userId)
    {
        $auth = Yii::$app->authManager;

        // Create the admin role
        $adminRole = $auth->createRole('admin');
        $auth->add($adminRole);

        // Assign the admin role to the specified user
        $auth->assign($adminRole, $userId);

        echo "Admin role created and assigned to user successfully.\n";
    }
}
