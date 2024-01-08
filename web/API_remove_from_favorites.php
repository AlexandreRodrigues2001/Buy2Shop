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

// Get the user ID from the session
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];

    // Get the item ID from the URL parameter
    if (isset($_GET['id'])) {
        $itemId = $_GET['id'];

        // Delete the item from favorites
        $sql = "DELETE FROM favorites WHERE userid = '$userId' AND itemid = '$itemId'";

        if (mysqli_query($conn, $sql)) {
            header('Location: favorites.php');
            exit();
        } else {
            echo "Error removing item from favorites: " . mysqli_error($conn);
        }
    } else {
        echo "Item ID not specified";
    }
} else {
    echo "User ID not available. Please log in.";
}

// Close the database connection
mysqli_close($conn);
?>
