<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inventory Home</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: Arial, sans-serif;
    }
    body {
      background-color: #f4f6f9;
    }
    header {
        
      background-color: #34495e ;
      padding: 20px 0;
      color: white;
      text-align: center;
    }
    header h1 {
      font-size: 36px;
    }
    /* #2c3e50 */
    nav {
      display: flex;
      justify-content: center;
      background-color: #34495e;
    }
    nav ul {
      display: flex;
      list-style: none;
    }
    nav ul li {
      margin: 0 20px;
    }
    nav ul li a {
      color: white;
      text-decoration: none;
      font-size: 18px;
      transition: color 0.3s;
    }
    nav ul li a:hover {
      color: #ff7b00;
    }
    .content {
      max-width:1200px;
      margin: 20px auto;
      padding: 20px;
      background-color: white;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    .content h2 {
      font-size: 30px;
      margin-bottom: 20px;
    }
    .features {
  display: grid;
  grid-template-columns: repeat(3, 1fr); /* 4 columns in one row */
  gap: 20px; /* Adds space between items */
  justify-content:center; /* Ensures proper alignment */
}

.feature-box {
  background-color: #ecf0f1;
  padding: 20px;
  text-align: center;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  border-radius: 8px;
}    .feature-box i {
      font-size: 40px;
      margin-bottom: 20px;
    }
    footer {
      background-color: #34495e;
      color: white;
      text-align: center;
      padding: 20px;
      position: fixed;
      bottom: 0;
      width: 100%;
    }
    a{
        color:black;
        text-decoration: none;
    }
  </style>
</head>
<body>

  <!-- Header Section -->
  <header>
    <h1>Inventory Management System</h1>
  </header>

    <!-- Main Content Section -->
  <div class="content">
    <h2>Welcome to the Inventory Management System</h2>
    <p>An inventory is a list of goods or materials a business holds for sale, production, or consumption. It helps organizations track stock levels, manage resources efficiently, and ensure they meet demand without overstocking. Effective inventory management reduces costs, prevents stockouts, and supports smooth operations.</p>
    <!-- Features Section -->
    <div class="features">
    <div class="feature-box">
    <a href="dash/dashboard.php">
        <i class="fa-solid fa-users"></i>
        <h3>Manage Users</h3>
        <p>Keep track of users, their roles, and permissions.</p></a>
      </div>
      <div class="feature-box">
      <a href="dash/dashboardS.php">
        <i class="fa-solid fa-cart-shopping"></i>
        <h3>Manage Suppliers</h3>
        <p>Track and manage customer orders efficiently.</p></a>
      </div>
      <div class="feature-box">
      <a href="dash/dashboardP.php">
        <i class="fa-solid fa-box"></i>
        <h3>Manage Products</h3>
        <p>Easily add, update, or remove products from your inventory.</p></a>
      </div>

      <div class="feature-box">
      <a href="dash/dashboardP.php">
        <i class="fa-solid fa-box"></i>
        <h3>Manage Purchase</h3>
        <p>Managing purchase orders , quantity , many more</p></a>
      </div>


    </div>
  </div>

  <!-- Footer Section -->
  <footer>
    <p>&copy; 2025 Inventory Management System. All rights reserved.</p>
  </footer>

</body>
</html>
