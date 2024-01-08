<?php
session_start(); // Start the session

// Set up CORS headers to allow requests from any domain
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Get the email and password from the request body
    $email = $_POST['email'] ?? '';
    $passwordInput = $_POST['password'] ?? '';

    // Validate the inputs
    if (empty($email) || empty($passwordInput)) {
        // Return an error response if the inputs are invalid
        http_response_code(400);
        echo json_encode(array('error' => 'Email and password are required'));
        exit;
    }

    // Check if the email and password match a record in the database
    $servername = "localhost";
    $username = "root";
    $dbPassword = ""; // Use a different variable name for the database password
    $dbname = "buy2shop";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $dbPassword);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email AND pass = :pass");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':pass', $passwordInput);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // If the email and password match, store the user ID in the session
            $_SESSION['user_id'] = $user['id'];

            // Return a success response and redirect to index_after_login.html
            http_response_code(200);
            echo json_encode(array('success' => 'Login successful'));
            header('Location: index_after_login.html');
            exit;
        } else {
            // If the email and password do not match, return an error response
            http_response_code(401);
            echo json_encode(array('error' => 'Invalid email or password'));
            exit;
        }

    } catch(PDOException $e) {
        // Return an error response if there is an error accessing the database
        http_response_code(500);
        echo json_encode(array('error' => 'Failed to login'));
        exit;
    }
} else {
    // Return an error response if the request method is not POST
    http_response_code(405);
    echo json_encode(array('error' => 'Method not allowed'));
    exit;
}
?>
