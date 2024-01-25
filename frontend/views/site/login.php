<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \common\models\LoginForm $model */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Employee Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h1 class="text-center"><?= Html::encode($this->title) ?></h1>

                        <p class="text-muted text-center">Please fill out the following fields to login:</p>

                        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                        <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'class' => 'form-control']) ?>

                        <?= $form->field($model, 'password')->passwordInput(['class' => 'form-control']) ?>
                        <div class="form-group">
                            <label>
                                <?= $form->field($model, 'showPassword')->checkbox(['id' => 'showPasswordCheckboxId']) ?>
                            </label>
                        </div>

                        <?= $form->field($model, 'rememberMe')->checkbox() ?>

                        <div class="my-1 mx-0" style="color:#999;">
                            If you forgot your password, you can <?= Html::a('reset it', ['site/request-password-reset']) ?>.
                            <br>
                            Need a new verification email? <?= Html::a('Resend', ['site/resend-verification-email']) ?>
                        </div>

                        <div class="form-group">
                            <?= Html::submitButton('Login', ['class' => 'btn btn-primary btn-block', 'name' => 'login-button']) ?>
                        </div>

                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>