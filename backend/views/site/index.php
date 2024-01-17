<?php

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
                    <button class="btn btn-outline-danger" disabled>View Details</button>
                </div>
            </div>
        </div>
    </div>
</div>