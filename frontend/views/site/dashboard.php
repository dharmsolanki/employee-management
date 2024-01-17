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
                    <?php
                    $imagePath = Yii::getAlias('@web/') . $model->image_path;
                    echo Html::img($imagePath, [
                        'alt' => 'User Avatar',
                        'class' => 'img-fluid mb-3',
                        'width' => 100, // Set your desired width here
                        'height' => 100, // Set your desired height here
                    ]);
                    ?>
                    <p class="card-text"><?= $model->username ?></p>
                    <p class="card-text"><?= $model->email ?></p>
                    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'], 'action' => Url::to(['site/upload'])]) ?>

                    <?= $form->field($model, 'imageFile')->fileInput() ?>

                    <button>Submit</button>

                    <?php ActiveForm::end() ?>
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
                        echo '<th>Action</th>'; // Add a new column for actions
                        echo '</tr>';
                        echo '</thead>';
                        echo '<tbody>';

                        foreach ($appliedLeaves as $leave) {
                            echo '<tr>';
                            echo '<td>' . Html::encode($leave->leave_type) . '</td>';
                            echo '<td>' . Html::encode($leave->reason) . '</td>';
                            echo '<td>' . Html::encode(date("d-m-Y", strtotime($leave->start_date))) . '</td>';
                            echo '<td>' . Html::encode(date("d-m-Y", strtotime($leave->end_date))) . '</td>';
                            echo '<td>' . Html::encode($leave->status == 0 ? 'Pending' : ($leave->status == 1 ? 'Approved' : 'Rejected')) . '</td>';

                            // Add the "Edit" button with a link to the edit action
                            if ($leave->status == 0) {

                                echo '<td>' . Html::a('Edit', ['site/edit', 'id' => $leave->id, 'userId' => $leave->user_id]) . '</td>';
                                echo '<td>' . Html::a('Cancel', ['site/delete', 'id' => $leave->id, 'userId' => $leave->user_id]) . '</td>';
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
                <div class="card-header">
                    <h5 class="card-title">Dashboard</h5>
                </div>

            </div>
        </div>
    </div>
</div>