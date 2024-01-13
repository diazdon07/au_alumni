<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>AU Cite Alumni Capstone Batch 2023</title>

  <!-- Local css/style.css -->
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/calendarDisplay.css">
  
  <script src="js/jquery-3.7.1.js"></script>
  <script src="css/bootstrap-5.0.2/js/bootstrap.bundle.min.js"></script>
  <script src="js/datatables.min.js"></script>
</head>
<body>
<?php 
  include 'db/dbcon.php';
  include 'nav.php';

  $page = isset($_GET['page']) ? $_GET['page'] :'home';
  include $page.'.php';

?>
<footer>@AuCiteAlumniCapstone</footer>
</body>
</html>
<script src="js/systemSetting.js"></script>