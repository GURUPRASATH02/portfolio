<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio</title>
    <link rel="stylesheet" href="css/view_project.css">
    <link rel="icon" href="img/Capture.PNG" type="png">
    <style>
        .card-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            margin-top: 30px;
        }
        .card {
            border: 1px solid #ddd;
            border-radius: 8px;
            width: 400px;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .card img {
            width: 100%;
            height: auto;
            border-radius: 8px;
        }
        .card h3 {
            font-size: 1.5em;
            margin: 10px 0;
        }
        .card p {
            margin: 10px 0;
        }
        .card a {
            color: #007BFF;
            text-decoration: none;
            margin-top: 10px;
            display: inline-block;
        }
        .card a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    
    <div class="card-container">
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

        // Retrieve project details from the database
        $sql = "SELECT * FROM projects";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Output data of each row
            while($row = $result->fetch_assoc()) {
                echo "<div class='card'>";
                echo "<img src='img/" . $row["example_img"] . "' alt='Project Image'>";
                echo "<h3>" . $row["project_name"] . "</h3>";
                echo "<p><strong>Front End:</strong> " . $row["front_end_tools"] . "</p>";
                echo "<p><strong>Back End:</strong> " . $row["back_end_tools"] . "</p>";
                echo "<p>" . $row["project_description"] . "</p>";
                echo "<a href='" . $row["github_url"] . "'>Github Link</a>";
                echo "</div>";
            }
        } else {
            echo "<p>No project details found</p>";
        }

        // Close database connection
        $conn->close();
        ?>
    </div>
</body>
</html>
