<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>
<div class="container mt-4">
    <div class="row">
        <div class="col-md-4">
            <div class="card border-primary">
                <div class="card-body">
                    <h5 class="card-title text-primary">Pending Leave Applications</h5>
                    <h2 class="text-primary"><?= count($pendingLeaves) ?></h2>
                    <a href="<?= Url::toRoute('site/pending-leaves') ?>" class="btn btn-outline-primary">View Details</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-success">
                <div class="card-body">
                    <h5 class="card-title text-success">Approved Leave Applications</h5>
                    <h2 class="text-success"><?= count($approvedLeaves) ?></h2>
                    <a href="<?= Url::toRoute('site/approved-leaves') ?>" class="btn btn-outline-success">View Details</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-danger">
                <div class="card-body">
                    <h5 class="card-title text-danger">Rejected Leave Applications</h5>
                    <h2 class="text-danger"><?= count($rejectedLeaves) ?></h2>
                    <a href="<?= Url::toRoute('site/rejected-leaves') ?>" class="btn btn-outline-success">View Details</a>
                </div>
            </div>
        </div>
    </div>
    <div class="btn-assign-task mt-4">
        <button class="btn btn-outline-success" id="btnAssignTask">Assign New Task</button>
    </div>
</div>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-4">
            <div class="card border-warning">
                <div class="card-body">
                    <h5 class="card-title text-warning">Tasks</h5>
                    <h2 class="text-warning"><?= count($tasks) ?></h2>
                    <a href="<?= Url::toRoute('site/assign-tasks-list') ?>" class="btn btn-outline-warning">View Details</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container mt-4" id="div_taskForm">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Create Task for Employee</h5>

                    <form action="<?= Url::toRoute('site/assign-task') ?>" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="<?= Yii::$app->request->csrfParam ?>" value="<?= Yii::$app->request->csrfToken ?>">
                        <div class="form-group">
                            <label for="employeeName">Select Employee</label>
                            <select class="form-control" id="employeeName" name="employee_id">
                                <option value="" selected>Select Employee</option>
                                <?php foreach ($user as $key => $model) {
                                    if ($model->id != 1) {
                                ?>
                                        <option value="<?= $model->id ?>"><?= $model->username ?></option>
                                <?php
                                    }
                                } ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="taskName">Task Name</label>
                            <input type="text" class="form-control" id="taskName" name="task_name" placeholder="Enter task name">
                        </div>

                        <div class="form-group">
                            <label for="prioritySelect">Priority</label>
                            <select class="form-control" id="prioritySelect" name="priority">
                                <option value="0">Low</option>
                                <option value="1">Medium</option>
                                <option value="2">High</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="dueDate">Due Date</label>
                            <input type="date" class="form-control" id="dueDate" name="due_date">
                        </div>

                        <div class="form-group">
                            <label for="taskDescription">Task Description</label>
                            <textarea class="form-control" id="taskDescription" name="description" rows="3" placeholder="Enter task description"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="pdfFile">Upload PDF File</label>
                            <input type="file" class="form-control" id="pdfFile" name="pdf_file">
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-success">Create Task</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>