<div class="card-body">
    <!-- Leave Application Form -->
    <h6 class="card-subtitle mb-3">Leave Application</h6>

    <?php

    use yii\helpers\Html;
    use yii\helpers\Url;
    use yii\widgets\ActiveForm;

    $form = ActiveForm::begin([
        'action' => Url::to(['site/apply-leave']),
        'method' => 'post',
        'options' => ['class' => 'leave-form'], // Add a custom class for styling
    ]); ?>

    <?= $form->field($model, 'leaveType')->dropDownList(
        [
            'sick' => 'Sick Leave',
            'vacation' => 'Vacation Leave',
            'personal' => 'Personal Leave',
        ],
        ['prompt' => 'Select Leave Type', 'class' => 'form-control']
    ) ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'startDate')->input('date', ['class' => 'form-control']) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'endDate')->input('date', ['class' => 'form-control']) ?>
        </div>
    </div>

    <?= $form->field($model, 'reason')->textarea(['rows' => 3, 'class' => 'form-control']) ?>

    <div class="form-group">
        <?= Html::submitButton('Submit Leave Application', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>