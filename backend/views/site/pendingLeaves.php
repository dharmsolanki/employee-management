<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var array $pendingLeaves */

$this->title = 'Admin Dashboard';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="admin-dashboard">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="applied-leaves">
        <h2>Applied Leaves</h2>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User Name</th>
                        <th>Leave Type</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Reason</th>
                        <th>Status</th>
                        <th>Action</th>
                        <!-- Add more headers as needed -->
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1; // Initialize the counter
                    foreach ($pendingLeaves as $model) : ?>
                        <tr>
                            <td><?= Html::encode($i++) ?></td>
                            <td>
                                <?php
                                // Fetch the corresponding user model
                                $userModel = $model->getUser()->one();

                                // Check if the user model exists and has a username property
                                $username = $userModel ? Html::encode($userModel->username) : 'N/A';
                                echo $username;
                                ?>
                            </td>
                            <td><?= Html::encode($model['leave_type']) ?></td>
                            <td><?= Html::encode($model['start_date']) ?></td>
                            <td><?= Html::encode($model['end_date']) ?></td>
                            <td><?= Html::encode($model['reason']) ?></td>
                            <td><?= Html::encode($model['status'] == 0 ? 'Pending' : ($model['status'] == 1 ? 'Approved' : 'Rejected')) ?></td>
                            <td>
                                <?= Html::a('Approve', ['site/approve-leave', 'userId' => $model['user_id'], 'id' => $model['id']], ['class' => 'btn btn-success', 'type' => 'button']) ?>
                                <?= Html::a('Reject', ['site/reject-leave', 'userId' => $model['user_id'], 'id' => $model['id']], ['class' => 'btn btn-danger', 'type' => 'button']) ?>
                            </td>
                            <!-- Add more cells as needed -->
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php if (count($pendingLeaves) == 0) {
            echo "<p>No Record Found.</p>";
        } ?>
    </div>
</div>