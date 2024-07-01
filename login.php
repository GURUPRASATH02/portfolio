<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio</title>
    <link rel="stylesheet" href="css/Loginstyle.css">
    <link rel="shortcut icon" href="img/Capture.PNG" type="image/x-icon">
    
</head>
<body>

    <form action="login.php" method="post">
        <label for="Admin_Pin">Admin-Pin</label>
        <input type="text" name="Admin_Pin" id="Admin_Pin" required>
        <label for="PassWord">Password</label>
        <input type="password" name="PassWord" id="PassWord" required>
        <button type="submit" class="btn" name="login">Login</button>
    </form>
    <p>This login is only for creator/admin.</p>
    <?php
        session_start();

        $hn = "localhost";
        $un = "root";
        $pw = "Guruprasath#02";
        $db = "Portfolio_Info";

        $conn = new mysqli($hn, $un, $pw, $db);
        if($conn->connect_error) die($conn->connect_error);

        if(isset($_POST["login"])){
            $admin_pin = $_POST["Admin_Pin"];
            $password = $_POST["PassWord"];

            // Prepared statement to prevent SQL injection
            $stmt = $conn->prepare("SELECT * FROM admins WHERE Admin_Pin = ? AND PassWord = ?");
            $stmt->bind_param("ss", $admin_pin, $password);
            $stmt->execute();
            $res = $stmt->get_result();

            if($res->num_rows > 0){
                $row = $res->fetch_assoc();
                $_SESSION["Admin_Pin"] = $row["Admin_Pin"];
                echo "<script>window.open('dashboard.php', '_self');</script>";
            } else {
                echo "<div class='error'>Invalid Admin Pin or Password.</div>";
            }

            $stmt->close();
        }
        

        $conn->close();
    ?>
</body>
</html>
