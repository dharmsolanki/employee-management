<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Edit Leave';
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title"><?= Html::encode($this->title) ?></h5>
                </div>
                <div class="card-body">
                    <?php $form = ActiveForm::begin(['id' => 'edit-leave-form']); ?>

                    <?= $form->field($model, 'leave_type')->dropDownList(['sick' => 'Sick Leave', 'vacation' => 'Vacation Leave', 'personal' => 'Personal Leave'], ['prompt' => 'Select Leave Type']) ?>

                    <?= $form->field($model, 'start_date')->input('date') ?>

                    <?= $form->field($model, 'end_date')->input('date') ?>

                    <?= $form->field($model, 'reason')->textarea(['rows' => 3]) ?>

                    <div class="form-group">
                        <?= Html::submitButton('Update Leave Application', ['class' => 'btn btn-primary']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>