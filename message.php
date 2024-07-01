<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reciceved Messages</title>
    <link rel="stylesheet" href="css/message.css">
    <link rel="icon" href="img/Capture.PNG" type="png">
</head>
<body>
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
    </div>
<h2>Message History</h2>

<table>
    <tr>
        <th>Name</th>
        <th>Phone</th>
        <th>Email ID</th>
        <th>Message</th>
    </tr>

    <?php
    // Establish database connection
    $hn = "localhost";
    $un = "root";
    $pw = "Guruprasath#02";
    $db = "Portfolio_Info";

    $conn = new mysqli($hn, $un, $pw, $db);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve hiring details from the database
    $sql = "SELECT * FROM msg";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Output data of each row
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["Name"] . "</td>";
            echo "<td>" . $row["Phone"] . "</td>";
            echo "<td>" . $row["EmailId"] . "</td>";
            echo "<td>" . $row["user_msg"] . "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='9'>No message details found</td></tr>";
    }

    // Close database connection
    $conn->close();
    ?>
</table>

</body>
</html>