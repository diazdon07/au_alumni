<header class="bg-body bg-gradient shadow">
  <div id="carouselExampleDark" class="carousel carousel-dark slide" data-bs-ride="carousel">
    <?php
      $current_date = date('Y-m-d');
      $sql = "SELECT * FROM `events` WHERE schedule >= '$current_date' ORDER BY schedule ASC LIMIT 5";
      $result = $conn->query($sql);
    ?>
    <div class="carousel-indicators">
      <?php
        $indicator_counter = 0;
        while ($row = $result->fetch_assoc()) {
            $active_class = ($indicator_counter == 0) ? 'active' : ''; // Add 'active' class to first indicator
      ?>
        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="<?= $indicator_counter ?>" class="<?= $active_class ?>" aria-label="Slide <?= $indicator_counter + 1 ?>"></button>
      <?php
        $indicator_counter++;
      }
      ?>
    </div>
    
    <div class="carousel-inner">
      <?php
        $item_counter = 0;
        $result->data_seek(0); // Reset result set pointer
        while ($row = $result->fetch_assoc()) {
            $active_class = ($item_counter == 0) ? 'active' : ''; // Add 'active' class to first item
      ?>
        <div class="carousel-item <?= $active_class ?>" data-bs-interval="2000">
            <img class="img-fluid d-block w-30 mx-auto" src="image/<?php 
            if($row['image']!==null){
              echo $row['image'];
            }else{
              echo 'image-placeholder.png';
            } 
            ?>" alt="Slide <?= $item_counter + 1 ?>">
            <div class="carousel-caption d-none d-md-block">
                <h5 class="text-warning"><?= $row['title'] ?></h5>
                <p class="image-content"><?= $row['schedule'].' '.$row['time'] ?></p>
            </div>
        </div>
      <?php
        $item_counter++;
      }
      $conn->close();
      ?>
    </div>
      <button class="carousel-control-prev bg-black" role="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
        <span class="sr-only">&lt; Previous</span>
      </button>
      <button class="carousel-control-next bg-black" role="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
        <span class="sr-only">Next &gt;</span>
      </button>
  </div>
</header>
<!-- modal alert -->
<div class="message-box" id="messageBox">
  <span class="close-button btn-close " role="button"></span>
  <p id="messageText"></p>
</div>

<div class="container-fluid" style="margin-top: 1rem;">
  <ul class="nav nav-tabs">
    <li class="nav-item" role="presentation">
      <a class="nav-link text-black active" aria-current="page" id="event-tab" data-bs-toggle="tab" 
      data-bs-target="#event" type="button" role="tab" aria-controls="event" aria-selected="true">Events</a>
    </li>
    <li class="nav-item">
      <a class="nav-link text-black" id="alumni-tab" data-bs-toggle="tab" 
      data-bs-target="#alumni" type="button" role="tab" aria-controls="alumni" aria-selected="false">Alumni</a>
    </li>
    <li class="nav-item">
      <a class="nav-link text-black" id="gallery-tab" data-bs-toggle="tab" 
      data-bs-target="#gallery" type="button" role="tab" aria-controls="gallery" aria-selected="false">Gallery</a>
    </li>
    <li class="nav-item">
      <a class="nav-link text-black" id="forum-tab" data-bs-toggle="tab" 
      data-bs-target="#forum" type="button" role="tab" aria-controls="forum" aria-selected="false">Forum</a>
    </li>
  </ul>
  <section class="tab-content area-content" id="myTabContent">
    <!-- Event Tabs -->
    <div class="tab-pane fade show active" id="event" role="tabpanel" aria-labelledby="event-tab">
      <div class="row">
        <div class="col-sm-3">
        <!-- Calendar -->
          <div class="calendar">
            <div class="calendar-header">
              <button id="prevBtn">&lt;</button>
              <h3 id="calendarTitle"></h3>
              <button id="nextBtn">&gt;</button>
            </div>
            <div class="week-days"></div>
            <div class="calendar-days"></div>
            <div class="event-details">
              <h4 id="eventTitle"></h4>
              <p>Date: <span id="eventDate"></span></p>
              <div id="eventDetails"></div>
              <!-- Add more fields for additional event details if needed -->
            </div>
          </div>
        </div>
        <div class="col-sm-9">
          <h6 id="datecontent"></h6>
          <div class="container">
            <div id="areacontent"></div>
          </div>
        </div>
      </div>
      <script src="js/eventCalendar.js"></script>
    </div>
    <!-- Alumni Tabs  -->
    <div class="tab-pane fade" id="alumni" role="tabpanel" aria-labelledby="alumni-tab">
      <div class="row">
        <div class="col sm-3">
          <div class="card" style="width: 18rem;">
            <div style="margin: 1rem;">
              <div class="input-group mb-3">
                <span class="input-group-text" id="addonSearch"><i class="fa fa-search"></i></span>
                <input type="text" name="search" class="form-control" id="search" aria-describedby="addonSearch" placeholder="Search...">
              </div>
              <div class="mb-3">
                <label>Filter By:</label>
              </div>
              <div class="input-group mb-3">
                <span class="input-group-text" id="addonGender">Gender</span>
                <select name="gender" id="gender" aria-describedby="addonGender" class="form-control">
                  <option>-Select Gender-</option>
                  <option value="0">Male</option>
                  <option value="1">Female</option>
                </select>
              </div>
              <div class="input-group mb-3">
                <span class="input-group-text" id="addonCourse">Course</span>
                <select id="course" aria-describedby="addonCourse" class="form-control">
                  <option>-Select Course-</option>
                </select>
              </div>
              <div class="input-group mb-3">
                <span class="input-group-text" id="addonYear">Batch</span>
                <select name="batch" id="year" aria-describedby="addonYear" class="form-control">
                  <option>-Select Batch-</option>
                </select>
              </div>
              <div class="mb-3">
                <select name="status" id="status" class="form-control">
                  <option>-Select Employment Status-</option>
                  <option>Unemployed</option>
                  <option>Employed</option>
                </select>
              </div>
              <button class="btn btn-primary" id="searchBtn">Search</button>
            </div>
          </div>
        </div>
        <div class="col-sm-9">
            <div class="alumnicontent row"></div>
          <div class="pagination-container text-center my-4"></div>
        </div>
      </div>
      <script src="js/alumnisView.js"></script>
    </div>
    <!-- Gallery Tabs  -->
    <div class="tab-pane fade" id="gallery" role="tabpanel" aria-labelledby="gallery-tab">
      Gallery Content.
    </div>
    <!-- Forum Tabs  -->
    <div class="tab-pane fade" id="forum" role="tabpanel" aria-labelledby="forum-tab">
      <!-- forum table -->
      <div class="main">
        <div class="row">
          <div class="col-3">
            <div class="input-group mb-3">
              <span class="input-group-text" id="addonSearch"><i class="fa fa-search"></i></span>
              <input type="text" name="search" class="form-control" id="search" aria-describedby="addonSearch" placeholder="Search...">
            </div>
          </div>
          <div class="col-2">
            <select name="" class="form-control" id="filter">
              <option hidden>Filter By:</option>
              <option value="">Popular</option>
              <option value="">Latest</option>
            </select>
          </div>
          <div class="col-2">
            <button type="button" class="btn btn-primary">Search</button>
          </div>
        </div>
        <table class="table table-hover">
          <thead>
            <th scope="col" class="text-center">Topics</th>
            <th scope="col" class="text-center" style="width: 10rem;">Replies</th>
          </thead>
          <tbody class="forumData">
             
          </tbody>
        </table>
        <!-- create topic -->
        <form id="createPost" class="card" enctype="multipart/form-data" style="padding: 1rem;">
          <div class="row g-3">
            <div class="col-8">
              <div class="mb-3">
                <input type="hidden" name="create" id="userS">
                <input type="text" name="topic" id="topicId" class="form-control" placeholder="Topic Title">
              </div>
              <div class="mb-3">
                <textarea class="form-control" rows="5" name="content" id="contentId" placeholder="Topic Content"></textarea>
              </div>
            </div>
            <div class="col-3">
              <img src="image/image-placeholder.png" class="rounded mx-auto d-block" style="width: 10rem;" id="dpl">
              <input type="file" class="form-control" name="file1" accept="image/*" id="postImg">
            </div>
            <div class="col-sm">
              <input type="submit" class="btn btn-primary" value="Create">
            </div>
          </div>
        </form>
      </div>
      <!-- post view -->
      <div class="post">
        <div class="mb-3">
          <a href="#" class="ptag text-muted"><i class="fa fa-chevron-left"></i> Back</a>
        </div>
        <div class="mb-3">
          <h2><i class="fa fa-book"></i>Treanding issue</h2>
          <p>By Admin | Posted Date 2024</p>
          <div class="card" style="padding: .5rem;">
            <img src="image/image-placeholder.png" class="img-fluid rounded mx-auto d-block" style="width: 70rem;">
            <p>message short story...</p>
          </div>
        </div>
        <div class="mb-3">
          <div class="row">
            <div class="col-1">
              <figure class="figure">
                <img src="image/image-placeholder.png" class="figure-img img-fluid rounded">
                <figcaption class="figure-caption text-center">Don McLin</figcaption>
              </figure>
            </div>
            <div class="col-11">
              <div class="card" style="padding: .5rem;">
                <p>dsadsaadsa</p>
              </div>
              <p class="text-end ptag">Replay Date: 2024</p>
            </div>
          </div>
          <div class="mb-3">
            <form action="" class="row g-2">
              <div class="col-11">
                <textarea class="form-control" rows="3"></textarea>
              </div>
              <div class="col-sm">
                <a class="replay btn text-muted" role="button" href=""><i class="fa fa-reply"></i>Replay</a>
              </div>
            </form>
          </div>
        </div>
      </div>
      <script src="js/forumFunction.js"></script>
    </div>
  </section>
</div>