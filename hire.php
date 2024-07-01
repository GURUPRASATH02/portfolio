<!DOCTYPE html>
<html>
<head>
    <title>Insert Hiring Details</title>
    <link rel="stylesheet" href="css/hire.css">
    <link rel="shortcut icon" href="img/Capture.PNG" type="image/x-icon">
</head>
<body>
    <div>
        <h2>Hire/Interview Call</h2>
    </div>
    <form action="hire.php" method="post">
        <label for="company_name">Company Name:</label><br>
        <input type="text" id="company_name" name="company_name" required><br><br>
        
        <label for="location">Location:</label><br>
        <input type="text" id="location" name="location" required><br><br>
        
        <label for="phone_number">Phone Number:</label><br>
        <input type="text" id="phone_number" name="phone_number" required><br><br>
        
        <label for="interview_date">Interview Date:</label><br>
        <input type="date" id="interview_date" name="interview_date" required><br><br>
        
        <label for="interview_time">Interview Time:</label><br>
        <input type="time" id="interview_time" name="interview_time" required><br><br>
        
        <label for="job_role">Job Role:</label><br>
        <input type="text" id="job_role" name="job_role" required><br><br>
        
        <label for="job_type">Job Type:</label><br>
        <select id="job_type" name="job_type" required>
            <option value="Part-time">Part-time</option>
            <option value="Full-time">Full-time</option>
            <option value="Day Shift">Day Shift</option>
            <option value="US Shift">US Shift</option>
            <option value="Night Shift">Night Shift</option>
        </select><br><br>
        
        <label for="job_description">Job Description:</label><br>
        <textarea id="job_description" name="job_description" rows="4" cols="50" required></textarea><br><br>
        
        <input type="submit" value="Submit">
    </form>
    <?php
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

        // Check if the form has been submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Check if all required fields are set
            if (isset($_POST['company_name']) && isset($_POST['location']) && isset($_POST['phone_number']) &&
                isset($_POST['interview_date']) && isset($_POST['interview_time']) && isset($_POST['job_role']) &&
                isset($_POST['job_type']) && isset($_POST['job_description'])) {

                // Prepare and bind
                $stmt = $conn->prepare("INSERT INTO hiring_details (company_name, location, phone_number, interview_date, interview_time, job_role, job_type, job_description) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("ssssssss", $company_name, $location, $phone_number, $interview_date, $interview_time, $job_role, $job_type, $job_description);

                // Set parameters and execute
                $company_name = $_POST['company_name'];
                $location = $_POST['location'];
                $phone_number = $_POST['phone_number'];
                $interview_date = $_POST['interview_date'];
                $interview_time = $_POST['interview_time'];
                $job_role = $_POST['job_role'];
                $job_type = $_POST['job_type'];
                $job_description = $_POST['job_description'];

                if ($stmt->execute()) {
                    echo "<p>Your Interview Call sent to Developer Successfully.</p>";
                } else {
                    echo "Error: " . $stmt->error;
                }

                $stmt->close();
            } else {
                echo "All fields are required.";
            }
        }

        $conn->close();
        ?>


</body>
</html>
