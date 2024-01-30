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

                    <div class="mb-3">
                        <?= $form->field($model, 'imageFile')->fileInput(['class' => 'form-control'])->label('<label class="form-label">Custom Label</label>') ?>
                    </div>

                    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary mt-3']) ?>

                    <?php ActiveForm::end() ?>
                </div>
            </div>

            <!-- Applied Leaves Box -->
            <div class="card mt-3">
                <div class="card-header bg-success text-white">
                    <h5 class="card-title mb-0">Applied Leaves</h5>
                </div>
                <div class="card-body">
                    <?php
                    $appliedLeaves = $model->getAppliedLeaves();
                    if (!empty($appliedLeaves)) {
                        echo '<div class="table-responsive">';
                        echo '<table class="table table-bordered table-hover">';
                        echo '<thead class="thead-light">';
                        echo '<tr>';
                        echo '<th>Leave Type</th>';
                        echo '<th>Reason</th>';
                        echo '<th>Start Date</th>';
                        echo '<th>End Date</th>';
                        echo '<th>Status</th>';
                        echo '<th>Reject Reason</th>'; // New column for Reject Reason
                        echo '<th>Action</th>';
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

                            // Display Reject Reason if status is 'Rejected'
                            echo '<td>' . ($leave->status == 2 ? Html::encode($leave->reject_reason) : '-') . '</td>';

                            // Add the "Edit" and "Cancel" buttons within a single button
                            echo '<td>';

                            // Check if status is not 'Approved' or 'Rejected' before rendering buttons
                            if ($leave->status == 0) {
                                echo '<div class="btn-group" role="group">';
                                echo Html::button('Edit/Cancel', ['class' => 'btn btn-warning btn-sm dropdown-toggle', 'data-toggle' => 'dropdown']);
                                echo '<div class="dropdown-menu">';
                                echo Html::a('Edit', ['site/edit', 'id' => $leave->id, 'userId' => $leave->user_id], ['class' => 'dropdown-item']);
                                echo Html::a('Cancel', ['site/delete', 'id' => $leave->id, 'userId' => $leave->user_id], ['class' => 'dropdown-item']);
                                echo '</div>';
                                echo '</div>';
                            } else {
                                echo "Access Denied";
                            }

                            echo '</td>';

                            echo '</tr>';
                        }

                        echo '</tbody>';
                        echo '</table>';
                        echo '</div>';
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
                    <h5 class="card-title mb-0">Task List</h5>
                </div>
                <div class="card-body">
                    <?php
                    if (!empty($tasks)) {
                        echo '<div class="table-responsive">';
                        echo '<table class="table table-bordered table-hover">';
                        echo '<thead class="thead-light">';
                        echo '<tr>';
                        echo '<th>Task Name</th>';
                        echo '<th>Priority</th>';
                        echo '<th>Due Date</th>';
                        echo '<th>Description</th>';
                        echo '<th>Status</th>';
                        echo '</tr>';
                        echo '</thead>';
                        echo '<tbody>';

                        foreach ($tasks as $task) {
                            echo '<tr>';
                            echo '<td>' . Html::encode($task->task_name) . '</td>';
                            echo '<td>' . Html::encode($task->getPriorityLabel()) . '</td>';
                            echo '<td>' . Html::encode(date("d-m-Y", strtotime($task->due_date))) . '</td>';
                            echo '<td>' . Html::encode($task->description) . '</td>';
                            echo '<td>';

                            // Dropdown for Status
                            echo Html::dropDownList(
                                'status',
                                $task->status,
                                [
                                    0 => 'Pending',
                                    1 => 'Completed',
                                ],
                                ['class' => 'form-control dropdown-status', 'data-task-id' => $task->id]
                            );

                            echo '</td>';
                            echo '</tr>';
                        }

                        echo '</tbody>';
                        echo '</table>';
                        echo '</div>';
                    } else {
                        echo "<p>No tasks found for this employee.</p>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>