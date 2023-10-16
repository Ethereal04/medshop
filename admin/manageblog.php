<?php
include('../db.php');

extract($_POST);

if (empty($id)) {
    $stmt = $con->prepare("INSERT INTO blog (blog_title) VALUES (?)");
    $stmt->bind_param("s", $name);

    if ($stmt->execute()) {
        echo 1;
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    $stmt = $con->prepare("UPDATE blog SET blog_title = ? WHERE blog_id = ?");
    $stmt->bind_param("si", $name, $id);

    if ($stmt->execute()) {
        echo 1;
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

mysqli_close($con);
?>