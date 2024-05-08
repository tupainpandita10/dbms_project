<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "mini";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $user_id = $_POST['user_id'];
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $phone_number = mysqli_real_escape_string($conn, $_POST['phone_number']);

 
    $sql_fetch = "SELECT phone_number FROM users WHERE user_id='$user_id'";
    $result = $conn->query($sql_fetch);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $existing_phone_number = $row["phone_number"];
    } else {
        echo "User not found";
        exit;
    }

    
    if ($phone_number !== $existing_phone_number) {
    
        $sql_check_duplicate = "SELECT user_id FROM users WHERE phone_number='$phone_number' AND user_id != '$user_id'";
        $result_check_duplicate = $conn->query($sql_check_duplicate);
        if ($result_check_duplicate->num_rows > 0) {
            echo "Phone number is already in use by another user";
          
            echo '<br><button onclick="history.back()" style="background-color: #4CAF50; /* Green */
                    border: none;
                    color: white;
                    padding: 15px 32px;
                    text-align: center;
                    text-decoration: none;
                    display: inline-block;
                    font-size: 16px;
                    margin: 4px 2px;
                    cursor: pointer;">Go Back to Update User</button>';
        } else {
            if (strlen($phone_number) === 10 && is_numeric($phone_number)) {
                $sql = "UPDATE users SET name='$name', phone_number='$phone_number' WHERE user_id='$user_id'";
                if ($conn->query($sql) === TRUE) {
                    echo "User updated successfully";
                    echo '<br><button onclick="window.location.href=\'view.php\'" style="background-color: #4CAF50; /* Green */
                            border: none;
                            color: white;
                            padding: 15px 32px;
                            text-align: center;
                            text-decoration: none;
                            display: inline-block;
                            font-size: 16px;
                            margin: 4px 2px;
                            cursor: pointer;">Back to Phonebook</button>';
                } else {
                    echo "Error updating user: " . $conn->error;
                }
            } else {
                echo "Phone number must be exactly 10 digits";
            }
        }
    } else {
        echo "New phone number is the same as the existing one";
       
        echo '<br><button onclick="history.back()" style="background-color: #4CAF50; /* Green */
                border: bold;
                color: white;
                padding: 20px 20px;
                text-align: center;
                text-decoration: none;
                display: inline-block;
                font-size: 16px;
                border-radius: 20px ;
               
                cursor: pointer;">Go Back to Update User</button>';
    }
} else {
    echo "Invalid request method";
}

$conn->close();
?>
