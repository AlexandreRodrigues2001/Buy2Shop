<?php

// Set up CORS headers to allow requests from any domain
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Get the email and password from the request body
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Validate the inputs
    if (empty($email) || empty($password)) {
        // Return an error response if the inputs are invalid
        http_response_code(400);
        echo json_encode(array('error' => 'Email and password are required'));
        exit;
    }

    // Insert the data into the database
    $servername = "localhost";
    $username = "root";
    $db_password = "";
    $dbname = "buy2shop";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $db_password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("INSERT INTO users (email, pass, saldo) VALUES (:email, :pass, 0 )");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':pass', $password);
        $stmt->execute();
        $conn = null;

        // Return a success response
        http_response_code(200);
        header('Location: login.html');
        echo json_encode(array('success' => 'User registered successfully'));
        exit;

    } catch(PDOException $e) {
        // Return an error response if the database insert fails
        http_response_code(500);
        echo json_encode(array('error' => 'Failed to register user'));
        exit;
    }
} else {
    // Return an error response if the request method is not POST
    http_response_code(405);
    echo json_encode(array('error' => 'Method not allowed'));
    exit;
}
