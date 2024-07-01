<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message to Admin</title>
    <link rel="stylesheet" href="css/contact.css">
    <link rel="shortcut icon" href="img/Capture.PNG" type="image/x-icon">
</head>
<body>
    <div class="contact-me">
        <div class="contact-form">
            <form action="contact.php" method="post">
                <h2>Send message</h2>
                <label for="Name">Name : </label>
                <input type="text" name="Name" id="Name" required>
                <label for="Phone">Phone : </label>
                <input type="text" name="Phone" id="Phone" required>
                <label for="EmailID">EmailID : </label>
                <input type="email" name="EmailId" id="EmailID" required>
                <label for="user_msg">Message : </label>
                <input type="text" name="user_msg" id="user_msg" required>
                <input type="submit" value="send message">
            </form>
        </div>
    </div>
    <?php
        $hn = "localhost";
        $un = "root";
        $pw = "Guruprasath#02";
        $db = "Portfolio_Info";

        $str = "mysql:host=".$hn.";dbname=".$db;

        try {
            $conn = new PDO($str, $un, $pw);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                $Name = $_POST['Name'] ?? '';
                $Phone = $_POST['Phone'] ?? '';
                $EmailId = $_POST['EmailId'] ?? '';
                $user_msg = $_POST['user_msg'] ?? '';

                $sql = "INSERT INTO msg (Name, Phone, EmailId, user_msg) VALUES (:Name, :Phone, :EmailId, :user_msg)";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':Name', $Name);
                $stmt->bindParam(':Phone', $Phone);
                $stmt->bindParam(':EmailId', $EmailId);
                $stmt->bindParam(':user_msg', $user_msg);

                if ($stmt->execute()) {
                    echo "Message sent successfully.";
                } else {
                    echo "Message not sent.";
                }
            }
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    ?>
</body>
</html>