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
                                <?= Html::a('Approve', 'javascript:void(0);', [
                                    'class' => 'btn btn-success',
                                    'type' => 'button',
                                    'onclick' => 'approveLeave(' . $model['user_id'] . ', ' . $model['id'] . ');',
                                ]) ?>

                                <?= Html::a('Reject', 'javascript:void(0);', [
                                    'class' => 'btn btn-danger',
                                    'type' => 'button',
                                    'onclick' => 'showRejectReasonModal(' . $model['id'] . ');',
                                ]) ?>
                            </td>
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

<!-- Modal for entering reject reason -->
<?php foreach ($pendingLeaves as $model) : ?>
    <div class="modal fade" id="rejectReasonModal<?= $model['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="rejectReasonModalLabel<?= $model['id'] ?>" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rejectReasonModalLabel<?= $model['id'] ?>">Enter Reject Reason</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="text" id="rejectReasonInput<?= $model['id'] ?>" name="rejectReason" placeholder="Enter reason" class="form-control">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="submitRejectReason(<?= $model['user_id'] ?>, <?= $model['id'] ?>)">Submit</button>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<script>
    function approveLeave(userId, leaveId) {
        // Construct the URL dynamically
        var url = '/site/approve-leave?userId=' + userId + '&id=' + leaveId;
        // Perform any additional logic as needed
        window.location.href = url;
    }

    function showRejectReasonModal(leaveId) {
        // Show the reject reason modal
        $('#rejectReasonModal' + leaveId).modal('show');
    }

    function submitRejectReason(userId, leaveId) {
        // Get the reject reason input value
        var rejectReason = $('#rejectReasonInput' + leaveId).val();

        // Construct the URL dynamically
        var url = '/site/reject-leave?userId=' + userId + '&id=' + leaveId + '&reason=' + encodeURIComponent(rejectReason);

        // Perform any additional logic as needed
        window.location.href = url;
    }
    
</script>