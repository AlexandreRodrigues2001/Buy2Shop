<?php
// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "buy2shop";
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Start the session
session_start();

// Retrieve the posted data
$data = json_decode(file_get_contents('php://input'), true);

// Get the item ID from the posted data
$itemId = $data['itemId'];

// Get the user ID from the session
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];

    // Check if the item already exists in favorites for the user
    $checkSql = "SELECT * FROM favorites WHERE itemId = '$itemId' AND userid = '$userId'";
    $checkResult = mysqli_query($conn, $checkSql);

    if (mysqli_num_rows($checkResult) > 0) {
        echo "Item already exists in favorites";
    } else {
        // Perform the database insert
        $sql = "INSERT INTO favorites (itemId, userid) VALUES ('$itemId', '$userId')";

        if (mysqli_query($conn, $sql)) {
            echo "Item added to favorites";
        } else {
            echo "Error adding item to favorites: " . mysqli_error($conn);
        }
    }
} else {
    echo "User ID not available. Please log in.";
}

// Close the database connection
mysqli_close($conn);
?>
