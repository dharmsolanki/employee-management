<?php

use yii\helpers\Url;

?>
<div class="container mt-4">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Pending Leave Applications</h5>
                    <h2><?= count($pendingLeaves) ?></h2>
                    <a href="<?= Url::toRoute('site/pending-leaves') ?>" class="btn btn-primary">Learn More</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Approved Leave Applications</h5>
                    <h2><?= count($approvedLeaves) ?></h2>
                    <a href="<?= Url::toRoute('site/approved-leaves') ?>" class="btn btn-primary">Learn More</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Rejected Leave Applications</h5>
                    <h2><?= count($rejectedLeaves) ?></h2>
                    <a href="#" class="btn btn-primary" style="pointer-events: none">Learn More</a>
                </div>
            </div>
        </div>
    </div>
</div>