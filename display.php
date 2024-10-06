<?php
// Display all uploaded images and their reports
$conn = new mysqli("localhost", "root", "", "medical_db");

$sql = "SELECT * FROM medical_images";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "Image: <img src='" . $row['image_url'] . "' width='200'><br>";
        echo "Report: " . $row['report'] . "<br><br>";
    }
} else {
    echo "No images found.";
}

$conn->close();
