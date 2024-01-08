<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
// Check if form is submitted
if (isset($_POST['submit'])) {
    // Get the form inputs
    $email = $_POST['email'];
    $password = $_POST['password'];
    $saldo = $_POST['saldo'];

    // Validate the inputs
    if (!empty($email) || !empty($password) || !empty($saldo)) {
        // Connect to the database (Replace with your own database credentials)
        $servername = "localhost";
        $username = "root";
        $db_password = "";
        $dbname = "buy2shop";

        $conn = new mysqli($servername, $username, $db_password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        session_start();
        $id = $_SESSION['user_id'];

        // Check if the new email is different from the previous one
        if (!empty($email)) {
            $sql = "SELECT email FROM users WHERE id = $id";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $previousEmail = $row['email'];

                if ($email !== $previousEmail) {
                    // Update the email in the database
                    $sql = "UPDATE users SET email = '$email' WHERE id = $id";
                    if ($conn->query($sql) !== true) {
                        echo "Error updating email: " . $conn->error;
                    } else {
                        echo "Email updated successfully<br>";
                    }
                }
            }
        }

        // Check if the new password is different from the previous one
        if (!empty($password)) {
            $sql = "SELECT pass FROM users WHERE id = $id";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $previousPassword = $row['pass'];

                if ($password !== $previousPassword) {
                    // Update the password in the database
                    $sql = "UPDATE users SET pass = '$password' WHERE id = $id";
                    if ($conn->query($sql) !== true) {
                        echo "Error updating password: " . $conn->error;
                    } else {
                        echo "Password updated successfully<br>";
                    }
                }
            }
        }

        // Check if the new saldo is different from the previous one
        if (!empty($saldo)) {
            $sql = "SELECT saldo FROM users WHERE id = $id";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $previousSaldo = $row['saldo'];

                if ($saldo !== $previousSaldo) {
                    // Update the saldo in the database
                    $newSaldo = $previousSaldo + $saldo; // Increase the existing saldo by the new value
                    $sql = "UPDATE users SET saldo = $newSaldo WHERE id = $id";
                    if ($conn->query($sql) !== true) {
                        echo "Error updating saldo: " . $conn->error;
                    } else {
                        echo "Saldo updated successfully<br>";
                    }
                }
            } else {
                // Insert the saldo into the database
                $sql = "INSERT INTO users (id, saldo) VALUES ($id, $saldo)";
                if ($conn->query($sql) !== true) {
                    echo "Error inserting saldo: " . $conn->error;
                } else {
                    echo "Saldo inserted successfully<br>";
                }
            }
        }

        $conn->close();

        // Redirect to a success page or display a success message
        header("Location: index_after_login.html");
        exit();
    }
}

