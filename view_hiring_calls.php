<!DOCTYPE html>
<html>
<head>
    <title>View Hiring Details</title>
    <link rel="stylesheet" href="css/calls.css">
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
    <?php
    // Database connection
    $hn = "localhost";
        $un = "root";
        $pw = "Guruprasath#02";
        $db = "Portfolio_Info";

        // Create connection
        $conn = new mysqli($hn, $un, $pw, $db);   

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // SQL query to fetch hiring details
    $sql = "SELECT * FROM hiring_details";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Outputting data in table format
        echo "<table>
                <tr>
                    <th>ID</th>
                    <th>Company Name</th>
                    <th>Location</th>
                    <th>Phone Number</th>
                    <th>Interview Date</th>
                    <th>Interview Time</th>
                    <th>Job Role</th>
                    <th>Job Type</th>
                    <th>Job Description</th>
                </tr>";
        // Output data of each row
        while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>".$row["id"]."</td>
                    <td>".$row["company_name"]."</td>
                    <td>".$row["location"]."</td>
                    <td>".$row["phone_number"]."</td>
                    <td>".$row["interview_date"]."</td>
                    <td>".$row["interview_time"]."</td>
                    <td>".$row["job_role"]."</td>
                    <td>".$row["job_type"]."</td>
                    <td>".$row["job_description"]."</td>
                </tr>";
        }
        echo "</table>";
    } else {
        echo "No hiring details found";
    }
    $conn->close();
    ?>
    
</body>
</html>
