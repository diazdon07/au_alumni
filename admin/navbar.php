        <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-light">
            <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-black min-vh-100">
                <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
                    <li>
                        <a href="index.php?page=dashboard" class="nav-link nav-dashboard px-0 align-middle" id="dashboard">
                            <i class="fa-solid fa-gauge"></i> <span class="ms-1 d-none d-sm-inline">Dashboard</span> </a>
                    </li>
                            <li class="w-100">
                                <a href="index.php?page=gallery" class="nav-link nav-gallery align-middle px-0" id="gallery">
                                    <i class="fa-solid fa-images"></i> <span class="ms-1 d-none d-sm-inline">Gallery List</span>
                                </a>
                            </li>
                            <li>
                                <a href="index.php?page=course" class="nav-link nav-course align-middle px-0" id="course">
                                    <i class="fa-solid fa-graduation-cap"></i> <span class="ms-1 d-none d-sm-inline">Course List</span>
                                </a>
                            </li>
                            <li>
                                <a href="index.php?page=alumni" class="nav-link nav-alumni align-middle px-0" id="alumni">
                                    <i class="fa-solid fa-user-graduate"></i> <span class="ms-1 d-none d-sm-inline">Alumni List</span>
                                </a>
                            </li>
                            <li>
                                <a href="index.php?page=job" class="nav-link nav-job align-middle px-0" id="job">
                                    <i class="fa-solid fa-user-tie"></i> <span class="ms-1 d-none d-sm-inline">Jobs List</span>
                                </a>
                            </li>
                            <li>
                                <a href="index.php?page=event" class="nav-link nav-event align-middle px-0" id="event">
                                    <i class="fa-solid fa-calendar-days"></i> <span class="ms-1 d-none d-sm-inline">Event List</span>
                                </a>
                            </li>
                            <li>
                                <a href="index.php?page=forum" class="nav-link nav-forum align-middle px-0" id="forum">
                                    <i class="fa-solid fa-comments"></i> <span class="ms-1 d-none d-sm-inline">Forum</span>
                                </a>
                    <li>
                        <a href="#" data-bs-target="#submenu2" data-bs-toggle="collapse" class="nav-link px-0 align-middle">
                            <i class="fa-solid fa-gears"></i> <span class="ms-1 d-none d-sm-inline">Maintenance</span> </a>
                        <ul class="collapse nav flex-column ms-1" id="submenu2" data-bs-parent="#menu">
                            <li>
                                <a href="index.php?page=users" class="nav-link nav-users align-middle px-0" id="user">
                                    <i class="fa-solid fa-user-gear"></i> <span class="ms-1 d-none d-sm-inline">Users</span>
                                </a>
                            </li>
                            <li>
                                <a href="index.php?page=system-settings" class="nav-link nav-system-settings align-middle px-0" id="setting">
                                    <i class="fa-solid fa-gear"></i> <span class="ms-1 d-none d-sm-inline">System Settings</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="index.php?page=report" class="nav-link nav-report align-middle px-0" id="report">
                            <i class="fa-brands fa-wpforms"></i> <span class="ms-1 d-none d-sm-inline">Report</span>
                        </a>
                    </li>
                </ul>
        </div>
<script>
    $('.nav_collapse').click(function(){
		console.log($(this).attr('href'))
		$($(this).attr('href')).collapse()
	})
    $('.nav-<?php echo isset($_GET['page']) ? $_GET['page'] : '' ?>')
</script>