<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "buy2shop";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

$categoria = mysqli_real_escape_string($conn, $_POST['categoria']);
$titulo = mysqli_real_escape_string($conn, $_POST['titulo']);
$descricao = mysqli_real_escape_string($conn, $_POST['descricao']);
$nome = mysqli_real_escape_string($conn, $_POST['nome']);
$telemovel = mysqli_real_escape_string($conn, $_POST['telemovel']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$cidade = mysqli_real_escape_string($conn, $_POST['cidade']);
$valor = mysqli_real_escape_string($conn, $_POST['valor']);

if (empty($categoria) || empty($titulo) || empty($descricao) || empty($nome) || empty($telemovel) || empty($email) || empty($cidade) || empty($valor)) {
    // One or more required fields are empty, so display an error message and stop processing the form
    die("Please fill out all required fields.");
}

// Get the ID of the currently logged in user
session_start();
if (!isset($_SESSION['user_id'])) {
    die("User not logged in.");
}
$user_id = $_SESSION['user_id'];

$insert_stmt = $conn->prepare("INSERT INTO anuncios (categoria, titulo, descricao, nome, telemovel, email, cidade, valor,user_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
$insert_stmt->bind_param("ssssssssi", $categoria, $titulo, $descricao, $nome, $telemovel, $email, $cidade, $valor, $user_id);

if (!$insert_stmt->execute()) {
    die("Error inserting data: " . $insert_stmt->error);
}

// Get the ID of the newly inserted row
$anuncio_id = $conn->insert_id;

if ($anuncio_id == 0) {
    die("No row inserted into the 'anuncios' table.");
}

$target_dir = "uploads/";

if (!file_exists($target_dir)) {
    mkdir($target_dir, 0777, true);
}

$photo_capa = basename($_FILES["fileselect"]["name"]);
$photo_1 = basename($_FILES["fileselect_1"]["name"]);
$photo_2 = basename($_FILES["fileselect_2"]["name"]);

$target_file_0 = $target_dir . $photo_capa;
$target_file_1 = $target_dir . $photo_1;
$target_file_2 = $target_dir . $photo_2;

$allowed_file_types = array('jpg', 'jpeg', 'png', 'gif');
$max_file_size = 5 * 1024 * 1024; // 5 MB

//upload photo capa
if (!empty($_FILES['fileselect']['name']) && !empty($_FILES['fileselect_1']['name']) && !empty($_FILES['fileselect_2']['name'])) {
    if (move_uploaded_file($_FILES["fileselect"]["tmp_name"], $target_file_0) && move_uploaded_file($_FILES["fileselect_1"]["tmp_name"], $target_file_1) && move_uploaded_file($_FILES["fileselect_2"]["tmp_name"], $target_file_2)) {
        // Prepare and bind the query for updating the "fotos" table
        

        function resizeImage($sourcePath, $destinationPath, $width, $height) {
            // Load the source image based on its type
            $sourceImageInfo = getimagesize($sourcePath);
            $sourceType = $sourceImageInfo[2];
            switch ($sourceType) {
                case IMAGETYPE_JPEG:
                    $sourceImage = imagecreatefromjpeg($sourcePath);
                    break;
                case IMAGETYPE_PNG:
                    $sourceImage = imagecreatefrompng($sourcePath);
                    break;
                case IMAGETYPE_GIF:
                    $sourceImage = imagecreatefromgif($sourcePath);
                    break;
                default:
                    // Unsupported image type
                    return false;
            }
        
            // Create a blank canvas for the resized image
            $resizedImage = imagecreatetruecolor($width, $height);
        
            // Calculate the aspect ratio of the source image
            $sourceWidth = imagesx($sourceImage);
            $sourceHeight = imagesy($sourceImage);
            $sourceAspectRatio = $sourceWidth / $sourceHeight;
        
            // Calculate the aspect ratio of the target dimensions
            $targetAspectRatio = $width / $height;
        
            // Calculate the new dimensions while preserving the aspect ratio
            if ($sourceAspectRatio > $targetAspectRatio) {
                $newWidth = $width;
                $newHeight = $width / $sourceAspectRatio;
            } else {
                $newWidth = $height * $sourceAspectRatio;
                $newHeight = $height;
            }
        
            // Calculate the position to center the resized image
            $x = ($width - $newWidth) / 2;
            $y = ($height - $newHeight) / 2;
        
            // Resize and copy the source image to the resized canvas
            imagecopyresampled($resizedImage, $sourceImage, $x, $y, 0, 0, $newWidth, $newHeight, $sourceWidth, $sourceHeight);
        
            // Save the resized image based on its type
            switch ($sourceType) {
                case IMAGETYPE_JPEG:
                    imagejpeg($resizedImage, $destinationPath, 100);
                    break;
                case IMAGETYPE_PNG:
                    imagepng($resizedImage, $destinationPath, 9);
                    break;
                case IMAGETYPE_GIF:
                    imagegif($resizedImage, $destinationPath);
                    break;
                default:
                    // Unsupported image type
                    return false;
            }
        
            // Destroy the images to free up memory
            imagedestroy($sourceImage);
            imagedestroy($resizedImage);
        
            return true;
        }
        
        // Resize the uploaded images
        $resized_capa = $target_dir . 'resized_' . $photo_capa;
        $resized_1 = $target_dir . 'resized_' . $photo_1;
        $resized_2 = $target_dir . 'resized_' . $photo_2;

        $resize_success_capa = resizeImage($target_file_0, $resized_capa, 500, 300);
        $resize_success_1 = resizeImage($target_file_1, $resized_1, 500, 300);
        $resize_success_2 = resizeImage($target_file_2, $resized_2, 500, 300);

        if ($resize_success_capa && $resize_success_1 && $resize_success_2) {
            // Resizing successful, continue with your code
            $insert_stmt_1 = $conn->prepare("INSERT INTO fotos (anuncio_id, photo_capa, photo_1, photo_2) VALUES (?, ?, ?, ?)");
            $insert_stmt_1->bind_param("isss", $anuncio_id, $resized_capa, $resized_1, $resized_2);
            $insert_stmt_1->execute();

            if ($insert_stmt->affected_rows > 0 && $insert_stmt_1->affected_rows > 0) {
                // All queries executed successfully, so redirect the user to a success page
                header("Location: index_after_login.html");
                exit();
            } else {
                // There was an issue with one of the queries, so display an error message
                die("There was an error inserting or updating data.");
            }
        } else {
            // Resizing failed, handle the error
            die("There was an error resizing the images.");
        }
    }
}

