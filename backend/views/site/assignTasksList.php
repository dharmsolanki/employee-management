<!-- assign-task-list.php -->

<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Assign Task List';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="site-assign-task-list">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            // Add columns based on your Task model attributes
            'id',
            'task_name',
            [
                'attribute' => 'employee_name',
                'value' => function ($model) {
                    return $model->employee->username; // Assuming 'employee' is the relation to the User model
                },
            ],
            'due_date:date',
            [
                'attribute' => 'priority',
                'value' => function ($model) {
                    return $model->getPriorityLabel(); // Assuming a method in your Task model to get the label
                },
            ],
            'description:ntext',
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    return $model->getStatusLabel();
                },
            ],

        ],
    ]); ?>

</div>