<?php
    $username = 'JohnDoe';
    $email = 'john.doe@example.com';
    ?>

    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <!-- User Profile Card -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">User Profile</h5>
                    </div>
                    <div class="card-body">
                        <img src="https://via.placeholder.com/150" alt="User Avatar" class="img-fluid mb-3">
                        <p class="card-text"><?= $username ?></p>
                        <p class="card-text"><?= $email ?></p>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <!-- Dashboard Content -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Dashboard</h5>
                    </div>
                    <div class="card-body">
                        <!-- Add your dashboard content here -->
                        <p>Welcome to your dashboard, <?= $username ?>!</p>
                        <!-- Sample content -->
                        <div class="alert alert-info" role="alert">
                            This is a sample dashboard content. Customize it based on your requirements.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>