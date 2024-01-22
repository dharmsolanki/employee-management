<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

// Assuming $model is an instance of the LeaveApplications model
// and $username, $email are provided somewhere in your context
$this->title = 'Dashboard';
?>

<div class="container mt-4">

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

    <div class="row">
        <div class="col-md-4">
            <!-- User Profile Card -->
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">User Profile</h5>
                </div>
                <div class="card-body">
                    <?php
                    $imagePath = Yii::getAlias('@web/') . $model->image_path;
                    echo Html::img($imagePath, [
                        'alt' => 'User Avatar',
                        'class' => 'img-fluid mb-3 rounded-circle',
                    ]);
                    ?>
                    <p class="card-text"><strong><?= $model->username ?></strong></p>
                    <p class="card-text"><?= $model->email ?></p>
                    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'], 'action' => Url::to(['site/upload'])]) ?>

                    <?= $form->field($model, 'imageFile')->fileInput(['class' => 'form-control-file']) ?>

                    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary mt-3']) ?>

                    <?php ActiveForm::end() ?>
                </div>
            </div>

            <!-- Applied Leaves Box -->
            <div class="card mt-3">
                <div class="card-header bg-success text-white">
                    <h5 class="card-title mb-0">Applied Leaves</h5>
                </div>
                <div class="card-body" style="max-height: 300px; overflow-y: auto;">
                    <?php
                    $appliedLeaves = $model->getAppliedLeaves();
                    if (!empty($appliedLeaves)) {
                        echo '<table class="table table-bordered table-hover">';
                        echo '<thead class="thead-light">';
                        echo '<tr>';
                        echo '<th>Leave Type</th>';
                        echo '<th>Reason</th>';
                        echo '<th>Start Date</th>';
                        echo '<th>End Date</th>';
                        echo '<th>Status</th>';
                        echo '<th>Action</th>'; // Add a new column for actions
                        echo '</tr>';
                        echo '</thead>';
                        echo '<tbody>';

                        foreach (array_reverse($appliedLeaves) as $leave) {
                            echo '<tr>';
                            echo '<td>' . Html::encode($leave->leave_type) . '</td>';
                            echo '<td>' . Html::encode($leave->reason) . '</td>';
                            echo '<td>' . Html::encode(date("d-m-Y", strtotime($leave->start_date))) . '</td>';
                            echo '<td>' . Html::encode(date("d-m-Y", strtotime($leave->end_date))) . '</td>';
                            echo '<td>' . Html::encode($leave->status == 0 ? 'Pending' : ($leave->status == 1 ? 'Approved' : 'Rejected')) . '</td>';

                            // Add the "Edit" and "Cancel" buttons within a single button
                            if ($leave->status == 0) {
                                echo '<td>';
                                echo Html::button('Edit/Cancel', ['class' => 'btn btn-warning btn-sm dropdown-toggle', 'data-toggle' => 'dropdown']);
                                echo '<div class="dropdown-menu">';
                                echo Html::a('Edit', ['site/edit', 'id' => $leave->id, 'userId' => $leave->user_id], ['class' => 'dropdown-item']);
                                echo Html::a('Cancel', ['site/delete', 'id' => $leave->id, 'userId' => $leave->user_id], ['class' => 'dropdown-item']);
                                echo '</div>';
                                echo '</td>';
                            } else {
                                echo '<td>Access Denied</td>';
                            }


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
                <div class="card-header bg-info text-white">
                    <h5 class="card-title mb-0">Dashboard Content</h5>
                </div>
                <div class="card-body">
                    <!-- Your dashboard content goes here -->
                </div>
            </div>
        </div>
    </div>
</div>