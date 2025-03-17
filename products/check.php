<?php
// Define the folder and the image name
$image_folder = __DIR__ . "/uploads/";
$image_name = "elia.png";  // Replace with a sample image name from your database or a specific image

// Check if the folder exists
if (is_dir($image_folder)) {
    echo "Folder exists: " . $image_folder . "<br>";

    // Check if the image exists inside the folder
    $image_path = $image_folder . $image_name;
    if (file_exists($image_path)) {
        echo "Image exists: " . $image_path;
    } else {
        echo "Image does not exist: " . $image_path;
    }
} else {
    echo "Folder does not exist: " . $image_folder;
}
?>
