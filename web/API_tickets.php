<?php

// Set up CORS headers to allow requests from any domain
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Get the email and password from the request body
    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $mensagem = $_POST['mensagem'] ?? '';

    // Insert the data into the database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "buy2shop";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("INSERT INTO tickets (name, email, message) VALUES (:nome, :email, :mensagem)");
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':mensagem', $mensagem);
        $stmt->execute();
        $conn = null;

        // Return a success response
        header('Content-Type: application/json');
        http_response_code(200);
        echo json_encode(array('success' => 'Message sent successfully'));
        header('Location: index_after_login.html');

    } catch(PDOException $e) {
        // Return an error response if the database insert fails
        header('Content-Type: application/json');
        http_response_code(500);
        echo json_encode(array('error' => $e->getMessage()));
    }
} else {
    // Return an error response if the request method is not POST
    header('Content-Type: application/json');
    http_response_code(405);
    echo json_encode(array('error' => 'Method not allowed'));
}
