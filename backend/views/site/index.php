<?php

use yii\helpers\Html;

use function PHPSTORM_META\type;

/** @var yii\web\View $this */
/** @var array $appliedLeaves */

$this->title = 'Admin Dashboard';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="admin-dashboard">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="applied-leaves">
        <h2>Applied Leaves</h2>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User ID</th>
                    <th>Leave Type</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Reason</th>
                    <th>Status</th>
                    <!-- Add more headers as needed -->
                </tr>
            </thead>
            <tbody>
                <?php foreach ($appliedLeaves as $model): ?>
                    <tr>
                        <td><?= Html::encode($model['id']) ?></td>
                        <td><?= Html::encode($model['user_id']) ?></td>
                        <td><?= Html::encode($model['leave_type']) ?></td>
                        <td><?= Html::encode($model['start_date']) ?></td>
                        <td><?= Html::encode($model['end_date']) ?></td>
                        <td><?= Html::encode($model['reason']) ?></td>
                        <td><?= Html::encode($model['status'] == 0 ? 'Pending' : 'Approved') ?></td>
                        <td><?= Html::a('Approve', ['site/approve-leave', 'userId' => $model['user_id'],'id' => $model['id']], ['class' => 'btn btn-success','type' => 'button']) ?></td>
                        <!-- Add more cells as needed -->
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
