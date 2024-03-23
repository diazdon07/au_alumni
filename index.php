<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>AU Cite Alumni Capstone Batch 2023</title>
  
  <!-- Bootstrap@5.3.2 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <!-- Local css/style.css -->
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/calendarDisplay.css">
  <link rel="stylesheet" href="css/chatbox.css">

  <!-- Data Tables & jquery 3.6.0 -->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
  <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
</head>
<body>
<ul class="notifications"></ul>
<?php 
  session_start();
  if (isset($_SESSION['user_info'])){
     $userData = $_SESSION['user_info'];
     $userId = json_encode($userData['id']);
     echo "<script>
      var userId = {$userId};
      </script>";
  }else{
    echo "<script>
      var userId;
      </script>";
  }
   

  include 'db/dbcon.php';
  include 'nav.php';

  $page = isset($_GET['page']) ? $_GET['page'] :'home';
  include $page.'.php';

?>
<!-- <div id="chat"></div> -->
<!-- <div id="chat_box" role="button">
  <i class="fa-brands fa-facebook-messenger"></i>
</div> -->
<footer class="bg-dark">
  <div class="row">
    <div class="col">
      <h6 class="text-white" style="color: white;">Contact Us:</h6>
      <span class="systemContact text-white"></span>
      <p class="systemEmail text-white"></p>
    </div>
    <div class="col">
      <!-- <h6><a href="index.php?page=term_condition" class="text-white">Term & Condition</a></h6> -->
      <h6><a href="index.php?page=privacy_policy" class="text-white">Privacy Policy</a></h6>
      <!-- <h6><a href="index.php?page=cookie_policy" class="text-white">Cookie Policy</a></h6> -->
    </div>
  </div>
</footer>
</body>
</html>
<script src="js/systemSetting.js"></script>
<script src="js/showMessage.js"></script>
<script src="js/chatSupport.js"></script>