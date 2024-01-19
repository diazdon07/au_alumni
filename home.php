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
    
    <div class="carousel-inner" style="height: 30rem;">
      <?php
        $item_counter = 0;
        $result->data_seek(0); // Reset result set pointer
        while ($row = $result->fetch_assoc()) {
            $active_class = ($item_counter == 0) ? 'active' : ''; // Add 'active' class to first item
      ?>
        <div class="carousel-item position-relative <?= $active_class ?>" data-bs-interval="4000">
          <div class="container-fluid position-absolute start-50 translate-middle" style="top: 15rem;">
            <img class="img-fluid d-block w-30 mx-auto" src="<?php 
            if($row['imgData']!==null&&$row['imgType']!==null){
              echo 'data:'.$row["imgType"].';base64,'.base64_encode($row["imgData"]);
            }else{
              echo 'image/image-placeholder.png';
            } 
            ?>" alt="Slide <?= $item_counter + 1 ?>">
          </div>
            <div class="carousel-caption d-none d-md-block position-absolute start-50 translate-middle" style="top: 18rem;">
                <h5 class="image-title"><?= $row['title'] ?></h5>
                <span class="image-content"><?= $row['schedule'].' '.$row['timestart'].'-'.$row['timeend'] ?> </span>
                <p class="image-content"><?= $row['shortdesc'] ?></p>
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

<div class="container-fluid" style="margin: 1rem 0rem;">
  <ul class="nav nav-tabs" id="items">
    
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
      <div class="container-fluid px-4">
        <div class="row g-5 card-row">
          
        </div>
      </div>
      <script src="js/galleryView.js"></script>
    </div>
    <!-- Job Tabs  -->
    <div class="tab-pane fade" id="job" role="tabpanel" aria-labelledby="job-tab">
      <div id="jobList">
        <table class="table table-hover" id="jobTable">
          <thead>
            <th class="text-center">Job Offers</th>
          </thead>
          <tbody class="jobOfferData">
            
          </tbody>
        </table>
      </div>
      <div id="viewJob">

      </div>
      <script src="js/jobOffers.js"></script>
    </div>
    <!-- Forum Tabs  -->
    <div class="tab-pane fade" id="forum" role="tabpanel" aria-labelledby="forum-tab">
      <!-- forum table -->
      <input type="hidden" name="create" id="userS">
      <div id="main">
        <table id="forumTable" class="table table-hover">
          <thead>
            <th scope="col" class="text-center">Topics</th>
            <th scope="col" class="text-center" style="width: 10rem;">Replies</th>
          </thead>
          <tbody class="forumData">
             
          </tbody>
        </table>
        <!-- create topic -->
        <div id="createTopic">
          
        </div>
      </div>
      <!-- post view -->
      <div id="post">
        
      </div>
      <script src="js/forumFunction.js"></script>
    </div>
  </section>
</div>
<script>

let user = JSON.parse(sessionStorage.user || null);

if(user != null){
  const itemUser = document.querySelector('#items');
          itemUser.innerHTML = '';
  
          const itemUserHTMLData = `
            <li class="nav-item" role="presentation">
              <a class="nav-link text-black active" aria-current="page" id="event-tab" data-bs-toggle="tab" 
              data-bs-target="#event" type="button" role="tab" aria-controls="event" aria-selected="true">Events</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-black" id="gallery-tab" data-bs-toggle="tab" 
              data-bs-target="#gallery" type="button" role="tab" aria-controls="gallery" aria-selected="false">Gallery</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-black" id="alumni-tab" data-bs-toggle="tab" 
              data-bs-target="#alumni" type="button" role="tab" aria-controls="alumni" aria-selected="false">Alumni</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-black" id="job-tab" data-bs-toggle="tab" 
              data-bs-target="#job" type="button" role="tab" aria-controls="ob" aria-selected="false">Job List</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-black" id="forum-tab" data-bs-toggle="tab" 
              data-bs-target="#forum" type="button" role="tab" aria-controls="forum" aria-selected="false">Forum</a>
            </li>
          `;
          itemUser.insertAdjacentHTML('beforeend', itemUserHTMLData);
    }else{
      const itemUser = document.querySelector('#items');
      itemUser.innerHTML = '';
  
      const itemUserHTMLData = `
      <li class="nav-item" role="presentation">
        <a class="nav-link text-black active" aria-current="page" id="event-tab" data-bs-toggle="tab" 
        data-bs-target="#event" type="button" role="tab" aria-controls="event" aria-selected="true">Events</a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-black" id="gallery-tab" data-bs-toggle="tab" 
        data-bs-target="#gallery" type="button" role="tab" aria-controls="gallery" aria-selected="false">Gallery</a>
      </li>
      `;
      itemUser.insertAdjacentHTML('beforeend', itemUserHTMLData);
}

</script>