<?php
include '../connection.php';
session_start();

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM plant WHERE plant_id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $name = $row['name'];
        $description = $row['description'];
        $existing_image = $row['image'];
        $container_soil = $row['container_soil'];
        $watering = $row['watering'];
        $sunlight = $row['sunlight'];
        $tips = $row['tips'];
    } else {
        echo "No plant found.";
        exit();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $container_soil = mysqli_real_escape_string($conn, $_POST['container_soil']);
    $watering = mysqli_real_escape_string($conn, $_POST['watering']);
    $sunlight = mysqli_real_escape_string($conn, $_POST['sunlight']);
    $tips = mysqli_real_escape_string($conn, $_POST['tips']);
    $id = $_POST['id'];
    $image_path = $existing_image; // Default to the existing image

    // Check if a new image is uploaded
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "../../images/";
        $image_name = basename($_FILES['image']['name']);
        $unique_name = uniqid() . "_" . $image_name;
        $target_file = $target_dir . $unique_name;
        $image_path = "../images/" . $unique_name; // Update new image path
        $image_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $allowed_types = array('jpg', 'jpeg', 'png', 'gif');
        if (in_array($image_type, $allowed_types)) {
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                // Delete old image if a new one is uploaded
                if (!empty($existing_image) && file_exists($target_dir . basename($existing_image))) {
                    unlink($target_dir . basename($existing_image));
                }
            } else {
                echo "Failed to upload the image. Please try again.";
                exit();
            }
        } else {
            echo "Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed.";
            exit();
        }
    }

    $sql = "UPDATE plant SET name='$name', description='$description', image='$image_path', 
            container_soil='$container_soil', watering='$watering', sunlight='$sunlight', tips='$tips' 
            WHERE plant_id='$id'";

    if ($conn->query($sql) === TRUE) {
        $role = $_SESSION['role'];
        if ($role === 'admin') {
            header("Location: adminpage.php?section=edit-plant&id=$id&status=success");
        } elseif ($role === 'agriculturist') {
            header("Location: agriculturistpage.php?section=edit-plant&id=$id&status=success");
        } else {
            echo "Invalid role.";
        }
        exit();
    } else {
        echo "Update Failed: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Plant</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body, html {
            height: 100%;
            margin: 0;
            overflow: hidden;
        }
        .d-flex {
            height: 100%;
            justify-content: center;
            align-items: center;
        }
        .footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            color: white;
            text-align: center;
            padding: 10px 0;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-5 fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="adminpage.php">Admin Dashboard</a>
        </div>
    </nav>

    <div class="d-flex">
        <div class="container p-5">
            <?php if (!empty($message)) echo "<p class='text-danger'>$message</p>"; ?>
            
            <form action="editplant.php?id=<?= $id ?>" method="POST" enctype="multipart/form-data" class="p-3 bg-success rounded-3 mt-5">
                <h2 class="fs-3 mb-4 text-white">Edit Plant Details:</h2>

                <input type="hidden" name="id" value="<?= $id ?>">

                <label for="name" class="form-label fw-semibold fs-5 text-white">Plant Name:</label>
                <input type="text" class="form-control mb-3" id="name" name="name" value="<?= htmlspecialchars($name) ?>" required>

                <label for="description" class="form-label fw-semibold fs-5 text-white">Description:</label>
                <textarea class="form-control mb-3" id="description" name="description" rows="3" required><?= htmlspecialchars($description) ?></textarea>

                <label for="image" class="form-label fw-semibold fs-5 text-white">Image:</label>
                <input type="file" class="form-control mb-3" id="image" name="image" accept="image/*">

                <label for="container_soil" class="form-label fw-semibold fs-5 text-white">Container & Soil:</label>
                <input type="text" class="form-control mb-3" id="container_soil" name="container_soil" value="<?= htmlspecialchars($container_soil) ?>" required>

                <label for="watering" class="form-label fw-semibold fs-5 text-white">Watering:</label>
                <input type="text" class="form-control mb-3" id="watering" name="watering" value="<?= htmlspecialchars($watering) ?>" required>

                <label for="sunlight" class="form-label fw-semibold fs-5 text-white">Sunlight:</label>
                <input type="text" class="form-control mb-3" id="sunlight" name="sunlight" value="<?= htmlspecialchars($sunlight) ?>" required>

                <label for="tips" class="form-label fw-semibold fs-5 text-white">Tips:</label>
                <input type="text" class="form-control mb-3" id="tips" name="tips" value="<?= htmlspecialchars($tips) ?>" required>

                <input type="submit" value="Update Plant" class="btn btn-light mt-3">
                <a href="adminpage.php#plantinder-management" class="btn btn-light mt-3">Back</a>
            </form>
        </div>
    </div>
</body>
</html>
