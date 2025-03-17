<?php
session_start();
$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>
<style>
   .sidebar {
      width: 250px;
      background-color: #34495e;
      color: white;
      height: 100vh;
      padding-top: 20px;
      position: fixed;
      top: 0;
      left: 0;
   }

   #header {
      font-size: 48px;
   }

   .sidebar-header h2 {
      text-align: center;
   }

   .sidebarImg img {
      width: 80px;
      height: 80px;
      border-radius: 50%;
      margin-left: +20px;
   }

   .sidebarImg {
      margin-bottom: 10px;
      margin-left: 60px;
   }

   .space {
      height: 1px;
      background-color: white;
   }

   .sidebarImg span {
      margin-left:-80px ;
      text-transform: uppercase;
      display: block;
      text-align: center;
      font-size: 22px;
   }

   .sidebar-menu {
      list-style: none;
      padding: 0;
   }

   .sidebar-menu li {
      position: relative;
   }

   .sidebar-menu a {
      display: block;
      padding: 15px;
      color: white;
      text-decoration: none;
      font-size: 18px;
      transition: background-color 0.3s;
   }

   .sidebar-menu a:hover {
      background-color:#34495e;
   }

   .submenu {
      display: none;
      list-style: none;
      padding: 0;
      margin: 0;
      background-color: #34495e;
   }

   .submenu li {
      padding-left: 20px;
   }

   .submenu a {
      padding: 10px 15px;
      font-size: 16px;
   }

   .submenu .submenu {
      position: absolute;
      left: 100%;
      top: 0;
      display: none;
      background-color: #34495e;
   }

   .sidebar-menu .dropdown.active > .submenu {
      display: block;
   }

   .fa-chevron-down, .fa-chevron-right {
      margin-left: 10px;
   }

   .sidebar-menu .dropdown.active > a {
      background-color: #2c3e50;
   }

   .head::after {
      display: block;
      content: "";
      height: 20px;
      background-color: #2c3e50;
      margin-top: 30px;
   }
</style>
<body>
<div class="sidebar">
    <div class="sidebar-header">
      <h2 id="header">IMS</h2>
      <div class="sidebarImg">
        <?php if(isset($user['image'])){ ?>
          <img src="../loging/<?= $user['image']?>"><?php } ?>
        <span><?= $user['firstName']?></span>
      </div>
      <div class="space"></div>
    </div>
    <ul class="sidebar-menu">
      <li class="dropdown">
        <a href="#" class="drop"><i class="fa-solid fa-box-open"></i> Suppliers <i class="fa-solid fa-chevron-down icon"></i></a>
        <ul class="submenu">
          <li><a href="../suppliers/view.php">View Suppliers</a></li>
          <li><a href="../suppliers/insert.php">Add New Supplier</a></li>
        </ul>
      </li>
    </ul>
  </div>
<script>
   $(document).ready(function(){
      $(".drop").click(function(event){
         event.preventDefault();
         let parent=$(this).parent();
         let parentSub=parent.find(".submenu");
         let icon=$(this).find(".icon");

         parentSub.slideToggle();

         if(icon.hasClass("fa-chevron-down")){
            icon.removeClass("fa-chevron-down").addClass("fa-chevron-up");
         }else{
            icon.removeClass("fa-chevron-up").addClass("fa-chevron-down");  
      }
      })
   })
  </script>
</body>
</html>
