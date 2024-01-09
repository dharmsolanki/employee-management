<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

// Assuming $model is an instance of the LeaveApplications model
// and $username, $email are provided somewhere in your context
$this->title = 'Dashboard';
?>

<div class="container">

    <?php if (Yii::$app->session->hasFlash('success')) : ?>
        <div id="flash-message" class="alert alert-success">
            <?= Yii::$app->session->getFlash('success') ?>
        </div>
    <?php endif; ?>

    <?php if (Yii::$app->session->hasFlash('error')) : ?>
        <div id="flash-message" class="alert alert-danger">
            <?= Yii::$app->session->getFlash('error') ?>
        </div>
    <?php endif; ?>

    <?php
    // JavaScript/jQuery code to automatically hide flash messages after 10 seconds
    $this->registerJs("
        setTimeout(function() {
            $('#flash-message').fadeOut('slow');
        }, 10000); // 10 seconds
    ");
    ?>

    <div class="row">
        <div class="col-md-4">
            <!-- User Profile Card -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">User Profile</h5>
                </div>
                <div class="card-body">
                    <!-- <img src="https://via.placeholder.com/150" alt="User Avatar" class="img-fluid mb-3"> -->
                    <p class="card-text"><?= $model->username ?></p>
                    <p class="card-text"><?= $model->email ?></p>
                </div>
            </div>

            <!-- Applied Leaves Box -->
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="card-title">Applied Leaves</h5>
                </div>
                <div class="card-body" style="overflow-x: auto; overflow-y: auto; max-height: 300px;">
                    <?php
                    $appliedLeaves = $model->getAppliedLeaves();
                    if (!empty($appliedLeaves)) {
                        echo '<table class="table table-bordered">';
                        echo '<thead>';
                        echo '<tr>';
                        echo '<th>Leave Type</th>';
                        echo '<th>Reason</th>';
                        echo '<th>Start Date</th>';
                        echo '<th>End Date</th>';
                        echo '<th>Status</th>';
                        echo '</tr>';
                        echo '</thead>';
                        echo '<tbody>';

                        foreach ($appliedLeaves as $leave) {
                            echo '<tr>';
                            echo '<td>' . Html::encode($leave->leave_type) . '</td>';
                            echo '<td>' . Html::encode($leave->reason) . '</td>';
                            echo '<td>' . Html::encode(date("d-m-Y", strtotime($leave->start_date))) . '</td>';
                            echo '<td>' . Html::encode(date("d-m-Y", strtotime($leave->end_date))) . '</td>';
                            echo '<td>' . Html::encode($leave->status == 0 ? 'Pending' : 'Approved') . '</td>';
                            echo '</tr>';
                        }

                        echo '</tbody>';
                        echo '</table>';
                    } else {
                        echo "<p>No applied leaves found.</p>";
                    }
                    ?>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <!-- Dashboard Content -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Dashboard</h5>
                </div>
                <div class="card-body">
                    <!-- Leave Application Form -->
                    <h6 class="card-subtitle mb-3">Leave Application</h6>

                    <?php $form = ActiveForm::begin([
                        'action' => Url::to(['site/apply-leave']),
                        'method' => 'post',
                    ]); ?>

                    <?= $form->field($model, 'leaveType')->dropDownList([
                        'sick' => 'Sick Leave',
                        'vacation' => 'Vacation Leave',
                        'personal' => 'Personal Leave',
                    ], ['prompt' => 'Select Leave Type']) ?>

                    <?= $form->field($model, 'startDate')->input('date') ?>

                    <?= $form->field($model, 'endDate')->input('date') ?>

                    <?= $form->field($model, 'reason')->textarea(['rows' => 3]) ?>

                    <div class="form-group">
                        <?= Html::submitButton('Submit Leave Application', ['class' => 'btn btn-primary']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
    </div>
</div>