<?php 
error_reporting(E_ALL);  
ini_set('display_errors', 1);

include '../connection.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_password'])) {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if any of the fields are empty
    if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
        $password_message = "All fields are required.";
        header("Location: ../agriculturistpage.php?section=settings&message=" . urlencode($password_message));
        exit();
    } else {
        $stmt = $conn->prepare("SELECT password FROM users WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($hashed_password);
            $stmt->fetch();

            if (password_verify($current_password, $hashed_password)) {
                if ($new_password === $confirm_password) {
                    $new_hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
                    $update_stmt = $conn->prepare("UPDATE users SET password = ? WHERE user_id = ?");
                    $update_stmt->bind_param("si", $new_hashed_password, $user_id);
                    if ($update_stmt->execute()) {
                        $password_message = "Password updated successfully.";
                        header("Location: agriculturistpage.php?section=settings&message=" . urlencode($password_message)); 
                        exit(); 
                    } else {
                        $password_message = "Error updating password: " . $conn->error;
                        header("Location: agriculturistpage.php?section=settings&message=" . urlencode($password_message));
                        exit();
                    }
                    $update_stmt->close();
                } else {
                    $password_message = "New passwords do not match.";
                    header("Location: agriculturistpage.php?section=settings&message=" . urlencode($password_message));
                    exit();
                }
            } else {
                $password_message = "Current password is incorrect.";
                header("Location: agriculturistpage.php?section=settings&message=" . urlencode($password_message));
                exit();
            }
        } else {
            $password_message = "User not found.";
            header("Location: agriculturistpage.php?section=settings&message=" . urlencode($password_message));
            exit();
        }

        $stmt->close();
    }
}
$conn->close();
?>
