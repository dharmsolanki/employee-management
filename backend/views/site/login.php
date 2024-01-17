<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \common\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Admin Login';
$this->params['body-class'] = 'bg-gradient-primary'; // Add a body class for background styling
?>
<div class="site-login">
    <div class="mt-5 col-lg-4 offset-lg-4">
        <div class="card">
            <div class="card-body">
                <h1 class="text-center"><?= Html::encode($this->title) ?></h1>

                <p class="text-muted text-center">Please fill out the following fields to login:</p>

                <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'class' => 'form-control']) ?>

                <?= $form->field($model, 'password')->passwordInput(['class' => 'form-control']) ?>

                <?= $form->field($model, 'rememberMe')->checkbox() ?>

                <div class="form-group">
                    <?= Html::submitButton('Login', ['class' => 'btn btn-primary btn-block', 'name' => 'login-button']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>