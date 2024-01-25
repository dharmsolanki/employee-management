<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \frontend\models\SignupForm $model */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Signup';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php if (Yii::$app->session->hasFlash('success')) : ?>
    <div class="alert alert-success" role="alert">
        <?= Yii::$app->session->getFlash('success') ?>
    </div>
<?php endif; ?>

<?php if (Yii::$app->session->hasFlash('error')) : ?>
    <div class="alert alert-danger" role="alert">
        <?= Yii::$app->session->getFlash('error') ?>
    </div>
<?php endif; ?>
<?php
// JavaScript/jQuery code to automatically hide flash messages after 10 seconds
$this->registerJs("
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 10000); // 10 seconds
    ");
?>
<div class="site-signup">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h1 class="card-title"><?= Html::encode($this->title) ?></h1>

                    <p>Please fill out the following fields to signup:</p>

                    <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

                    <?= $form->field($model, 'username')->textInput(['autofocus' => true])->label('Username') ?>

                    <?= $form->field($model, 'email')->label('Email') ?>

                    <?= $form->field($model, 'password')->passwordInput()->label('Password') ?>
                    <div class="form-group">
                        <label>
                            <?= $form->field($model, 'showPassword')->checkbox(['id' => 'showPasswordCheckboxId']) ?>
                        </label>
                    </div>

                    <div class="form-group">
                        <?= Html::submitButton('Signup', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>