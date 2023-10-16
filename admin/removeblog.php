<?php
include '../db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $stmt = $con->prepare("DELETE FROM blog WHERE blog_id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo 1;
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Error: Invalid or missing ID parameter.";
}

mysqli_close($con);
?>