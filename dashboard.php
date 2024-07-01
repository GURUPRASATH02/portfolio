<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hi Admin</title>
  <link rel="stylesheet" href="css/dashboard.css">
  <link rel="icon" href="img/Capture.PNG" type="image/x-icon">
  <style>
    /* dashboard.css styles */
    * {
    padding: 0;
    margin: 0;
    box-sizing: border-box; /* Add box-sizing to ensure padding and border are included in the element's total width and height */
}

/* Navigation Bar */
.navi {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px;
    background-color: #f45;
    color: #fff;
}

.navi ul {
    display: flex;
    list-style: none;
    margin: 0;
}

.navi ul li {
    margin-left: 20px;
}

a {
    text-decoration: none;
    color: #fff;
    padding: 10px 20px;
}


/* Dashboard */
.dashboard {
    width: 350px;
    height: 400px;
    background-color: rgb(233, 179, 183);
    margin-left:10%;
    margin-top:30px;
    padding: 20px;
    border-radius: 20px;
    text-align: center;
}

.dashboard h2 {
    color: blueviolet;
    padding: 10px;
}

.links ul {
    list-style: none;
    padding: 0;
}

.links ul li {
    padding: 10px;
}

.link-items a {
    text-decoration: none;
    color: blueviolet;
}

/* Form */
form {
    width: 400px;
    padding: 20px;
    border: none;
    border-radius: 5px;
    background-color: #f9f9f9;
    margin-top:-200px;
    justify-content: center;
    margin-left: 150%; /* Center form and set margin */
}

form label, form input[type="text"], form input[type="password"], form input[type="submit"] {
    display: block;
    width: 100%;
    margin-bottom: 10px;
    padding: 5px;
}

form input[type="submit"] {
    width: auto;
    padding: 10px 20px;
    background-color: #007bff;
    border: none;
    border-radius: 3px;
    color: #fff;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

form input[type="submit"]:hover {
    background-color: #0056b3;
}

/* Messages */
.error {
    color: #e74c3c;
    font-weight: bold;
    margin-top: 10px;
    text-align: center;
    
}

.success {
    color: #2ecc71;
    font-weight: bold;
    margin-top: 10px;
    text-align: center;
    
}
/* Large screens (desktops, 992px and above) */
@media (min-width: 992px) {
    .navi {
        padding: 20px 40px;
    }

    .logo img {
        max-width: 600px;
    }

    .dashboard {
        max-width: 400px;
        padding: 30px;
    }

    form {
        max-width: 500px;
    }
}

/* Medium screens (tablets, between 768px and 991px) */
@media (min-width: 768px) and (max-width: 991px) {
    .navi {
        flex-direction: row;
        align-items: flex-start;
    }

    .navi ul {
        flex-direction: row;
        align-items: flex-start;
    }

    .logo img {
        max-width: 500px;
    }

    .dashboard {
        max-width: 350px;
    }

    form {
        max-width: 400px;
        margin-left: 24%;
    }
}

/* Small screens (mobile devices, below 768px) */
@media (max-width: 767px) {
    .navi {
        flex-direction: row;
        align-items: center;
        padding: 10px;
    }

    .navi ul {
        flex-direction: row;
        align-items: center;
    }

    .navi ul li {
        margin-left: 0;
        margin-bottom: 10px;
    }

    .logo img {
        max-width: 80%;
    }

    .logo #text1, #text2 {
        padding: 5px;
        text-align: center;
    }

    .dashboard {
        width: 90%;
        margin: 20px auto;
    }

    form {
        width: 90%;
        margin-left: 10%;
    }
}

  </style>
</head>
<body>
<?php
  session_start();

  if (!isset($_SESSION['Admin_Pin'])) {
    echo "<script>window.open('login.php?msg=Please login to access the dashboard', '_self');</script>";
    exit();
  }
?>
  <div class="navi">
    <h2>Hi, Admin</h2>
    <nav>
      <ul>
        <li><a href="dashboard.php?action=settings">Settings</a></li>
        <li><a href="logout.php">Logout</a></li>
      </ul>
    </nav>
  </div>

  <div class="dashboard">
    <h2><a href="dashboard.php">DASHBOARD</a></h2>
    <hr>
    <div class="links">
      <ul class="link-items">
        <li><a href="project.php">Post Project</a></li>
        <li><a href="certificates.php">Post Certifications</a></li>
        <li><a href="blog.php">Post Blog</a></li>
        <li><a href="view_hiring_calls.php">View Interview Calls</a></li>
        <li><a href="message.php">Messages</a></li>
      </ul>
    </div>

    <?php
      $servername = "localhost";
      $username = "root";
      $password = "Guruprasath#02";
      $dbname = "Portfolio_Info";

      $conn = new mysqli($servername, $username, $password, $dbname);

      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }

      if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_GET['action']) && $_GET['action'] == 'settings') {
        $new_admin_pin = filter_input(INPUT_POST, 'new_admin_pin', FILTER_SANITIZE_NUMBER_INT);
        $new_password = filter_input(INPUT_POST, 'new_password', FILTER_SANITIZE_STRING);

        if (!empty($new_admin_pin) && !empty($new_password)) {
          $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

          $stmt = $conn->prepare("UPDATE admins SET Admin_Pin = ?, PassWord = ? WHERE Admin_Pin = ?");
          $stmt->bind_param("sss", $new_admin_pin, $hashed_password, $_SESSION["Admin_Pin"]);

          if ($stmt->execute()) {
            echo "<div class='success'>Credentials updated successfully!</div>";
            $_SESSION["Admin_Pin"] = $new_admin_pin;
          } else {
            $error_msg = "Error updating credentials: " . $conn->error;
            if ($conn->errno == 1062) {
              $error_msg = "This PIN is already in use.";
            }
            echo "<div class='error'>$error_msg</div>";
          }

          $stmt->close();
        } else {
          echo "<div class='error'>Please enter both PIN and password.</div>";
        }
      }

      if (isset($_GET['action']) && $_GET['action'] == 'settings') {
    ?>
    <form method="post" action="dashboard.php?action=settings">
      <label for="new_admin_pin">New Admin Pin:</label>
      <input type="text" id="new_admin_pin" name="new_admin_pin" required pattern="[0-9]+" title="Please enter numbers only for PIN">
      <br>
      <label for="new_password">New Password:</label>
      <input type="password" id="new_password" name="new_password" required>
      <br>
      <input type="submit" value="Update Credentials">
    </form>
    <?php
      }
    ?>
  </div>
</body>
</html>
