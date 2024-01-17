<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Edit Leave';
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title"><?= Html::encode($this->title) ?></h5>
                </div>
                <div class="card-body">
                    <?php $form = ActiveForm::begin(['id' => 'edit-leave-form']); ?>

                    <?= $form->field($model, 'leave_type')->dropDownList(
                        ['sick' => 'Sick Leave', 'vacation' => 'Vacation Leave', 'personal' => 'Personal Leave'],
                        ['prompt' => 'Select Leave Type', 'class' => 'form-control']
                    ) ?>

                    <?= $form->field($model, 'start_date')->input('date', ['class' => 'form-control']) ?>

                    <?= $form->field($model, 'end_date')->input('date', ['class' => 'form-control']) ?>

                    <?= $form->field($model, 'reason')->textarea(['rows' => 3, 'class' => 'form-control']) ?>

                    <div class="form-group">
                        <?= Html::submitButton('Update Leave Application', ['class' => 'btn btn-primary']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>