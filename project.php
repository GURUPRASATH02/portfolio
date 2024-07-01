<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Post Project</title>
    <link rel="stylesheet" href="css/project.css">
    <link rel="icon" href="img/Capture.PNG" type="png">
    <style>
        .navi ul li {
    margin-left: 20px;
    list-style: none;
}

a {
    text-decoration: none;
    color: #fff;
    padding: 10px 20px;
}

.dashboard {
    width: 80%;
    max-width: 300px;
    height: auto;
    background-color: rgb(233, 179, 183);
    margin-top: 30px;
    margin-left: 50px;
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
    <label for="project_name">Project Title</label>
    <input type="text" id="project_name" name="project_name" required>
    <label for="front_end_tools">front_end_tools</label>
    <input type="text" name="front_end_tools" id="front_end_tools" required>
    <label for="back_end_tools">back_end_tools</label>
    <input type="text" name="back_end_tools" id="back_end_tools" required>
    <label for="project_description">project_description</label>
    <input type="text" name="project_description" id="project_description" required>
    <label for="example_img">Example Image</label>
    <input type="file" name="example_img" id="example_img" required>
    <label for="github_url">Github</label>
    <input type="url" name="github_url" id="github_url" required>
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

    $project_name = $_POST['project_name'];
    $front_end_tools = $_POST['front_end_tools'];
    $back_end_tools = $_POST['back_end_tools'];
    $project_description = $_POST['project_description'];
    $github_url = $_POST['github_url'];
    $example_img = $_FILES['example_img']['name'];
    $temp_image = $_FILES['example_img']['tmp_name'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($example_img);

    // Check if image file is an actual image or fake image
    $check = getimagesize($temp_image);
    if ($check !== false) {
        // Check file size
        if ($_FILES["example_img"]["size"] <= 500000) {
            // Allow certain file formats
            $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            if ($image_file_type == "jpg" || $image_file_type == "png" || $image_file_type == "jpeg" || $image_file_type == "gif") {
                // Check if file already exists
                if (!file_exists($target_file)) {
                    // Move uploaded file to desired location
                    if (move_uploaded_file($temp_image, $target_file)) {
                        // Insert into database
                        $sql = "INSERT INTO projects (project_name, front_end_tools,back_end_tools, project_description, example_img,github_url) VALUES ('$project_name', '$front_end_tools', '$back_end_tools','$project_description','$example_img','$github_url')";
                        if ($conn->query($sql) === TRUE) {
                            echo "<h3><i>project posted  successfully</i></h3>";
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