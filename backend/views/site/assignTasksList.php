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
            // Add more columns as needed

            // Action column for view, update, and delete buttons
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['view', 'id' => $model->id]);
                    },
                    'update' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['update', 'id' => $model->id]);
                    },
                    'delete' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete', 'id' => $model->id], [
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this item?',
                                'method' => 'post',
                            ],
                        ]);
                    },
                ],
            ],
        ],
    ]); ?>

</div>