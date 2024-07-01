<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Post Certifications</title>
    <link rel="stylesheet" href="css/certificates.css">
    <link rel="icon" href="img/Capture.PNG" type="png">
    <style>
        .form {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            
        }

        form {
            display: flex;
            flex-wrap: wrap;
            align-content: center;
            width: 100%;
            max-width: 600px;
            margin-left:500px;
            margin-top:-250px;
        }

        form label {
            width: 100%;
            padding: 10px;
        }

        form input {
            width: 100%;
            height: 40px;
            text-align: justify;
            padding-left: 10px;
            border-radius: 15px;
            margin-bottom: 10px;
        }

        input[type="submit"] {
            width: 100px;
            height: 50px;
            margin-top: 30px;
            cursor: pointer;
            background-color: rgb(238, 57, 40);
            color: white;
            border: none;
            border-radius: 10px;
            text-align: center;
        }

        /* Media Query for smaller screens */
        @media (max-width: 768px) {
            .navi {
                flex-direction: row;
                align-items: flex-start;
            }

            .navi ul {
                flex-direction: row;
                width: 100%;
            }

            .navi ul li {
                margin: 10px 0;
            }

            .dashboard {
                width: 90%;
                margin: 20px auto;
            }

            .form {
                padding: 10px;
                
            }

            form {
                width: 70%;
                margin-left:10%;
                margin-top:100px;
            }
        }
    </style>
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
    <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">
    <label for="course">course:</label>
    <input type="text" id="course" name="course" required>
    <label for="image">Image:</label>
    <input type="file" id="image" name="image">
    <label for="organization_name">certified organization name</label>
    <input type="text" name="organization_name" id="organization_name">
    <input type="submit" value="Submit">
</form>

<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
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

    $course = $_POST['course'];
    $organization_name = $_POST['organization_name'];
    $image = $_FILES['image']['name'];
    $temp_image = $_FILES['image']['tmp_name'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($image);

    // Check if image file is an actual image or fake image
    $check = getimagesize($temp_image);
    if ($check !== false) {
        // Check file size
        if ($_FILES["image"]["size"] <= 500000) {
            // Allow certain file formats
            $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            if ($image_file_type == "jpg" || $image_file_type == "png" || $image_file_type == "jpeg" || $image_file_type == "gif") {
                // Check if file already exists
                if (!file_exists($target_file)) {
                    // Move uploaded file to desired location
                    if (move_uploaded_file($temp_image, $target_file)) {
                        // Insert into database
                        $sql = "INSERT INTO certificates (course, image, organization_name) VALUES ('$course', '$image', '$organization_name')";
                        if ($conn->query($sql) === TRUE) {
                            echo "<h3><i>Certification post submitted successfully</i></h3>";
                        } else {
                            echo "Error: " . $sql . "<br>" . $conn->error;
                        }
                    } else {
                        echo "Sorry, there was an error uploading your file.";
                    }
                } else {
                    echo "Sorry, file already exists.";
                }
            } else {
                echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            }
        } else {
            echo "Sorry, your file is too large.";
        }
    } else {
        echo "File is not an image.";
    }

    $conn->close();
}
?>

</body>
</html>