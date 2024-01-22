<?php
use yii\helpers\Html;
$this->title = 'Admin Dashboard';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="admin-dashboard">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="applied-leaves">
        <h2>Rejected Leaves</h2>

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
                    $i = 1;
                    foreach ($rejectedLeaves as $model) : ?>
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
                                <button class="btn btn-success approve-button" data-user-id="<?= $model['user_id'] ?>" data-leave-id="<?= $model['id'] ?>">Approve</button>
                            </td>
                            <!-- Add more cells as needed -->
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php if (count($rejectedLeaves) == 0) {
            echo "<p>No Record Found.</p>";
        } ?>
    </div>
</div>

<script>
    // JavaScript to handle the rejection
    document.addEventListener('DOMContentLoaded', function () {
        var rejectButtons = document.querySelectorAll('.approve-button');

        rejectButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                var userId = button.getAttribute('data-user-id');
                var leaveId = button.getAttribute('data-leave-id');
                var approveUrl = '/site/approve-rejected-leave?userId=' + userId + '&id=' + leaveId;

                // Perform any additional logic as needed

                // Redirect to the reject URL
                window.location.href = approveUrl;
            });
        });
    });
</script>
