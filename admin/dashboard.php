                <!-- dashboard  -->
                <div class="card" id="dashboardForm">
                    <div class="card-header">
                        <i class="fa-solid fa-gauge"></i><span class="ms-1 d-sm-inline">Dashboard</span>
                    </div>
                    <div class="row row-cols-1 row-cols-md-4 g-4">
                        <!-- user count -->
                        <div class="card-body">
                        <div class="card card-width bg-primary text-bg-dark bg-gradient">
                            <div class="card-header text-end">
                                <?php
                                $i = 1;
                                foreach( $users as $user ):
                                ?>
                                <h2><?= $i++ ?></h2>
                                <?php
                                endforeach;
                                ?>
                            </div>
                            <div class="card-body">
                                Users
                            </div>
                        </div>
                        </div>
                        <!-- course count -->
                        <div class="card-body">
                            <div class="card card-width bg-info text-bg-dark bg-gradient">
                            <div class="card-header text-end">
                                <?php
                                $c = 1;
                                $result = mysqli_query($conn,'SELECT * FROM `courses`');
                                if(mysqli_num_rows($result) > 0):
                                ?>
                                <h2><?= $c++ ?></h2>
                                <?php
                                endif;
                                ?>
                            </div>
                            <div class="card-body">
                                Courses
                            </div>
                            </div>
                        </div>
                        <!-- Alumni count -->
                        <div class="card-body">
                            <div class="card card-width bg-warning text-bg-dark bg-gradient">
                            <div class="card-header text-end">
                                <h2>10</h2>
                            </div>
                            <div class="card-body">
                                Alumni
                            </div>
                            </div>
                        </div>
                        <!-- Job count -->
                        <div class="card-body">
                            <div class="card card-width bg-danger text-bg-dark bg-gradient">
                            <div class="card-header text-end">
                                <h2>10</h2>
                            </div>
                            <div class="card-body">
                                Jobs
                            </div>
                            </div>
                        </div>
                    </div>
                    
                </div>