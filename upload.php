<?php
// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uploadDir = 'uploads/'; // Directory where images will be uploaded

    // Check if file was uploaded without errors
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
        $allowedTypes = ['image/jpeg', 'image/png'];
        $allowedExtensions = ['jpg', 'jpeg', 'png'];
        $maxFileSize = 5 * 1024 * 1024; // 5 MB (in bytes)

        // Validate file type
        if (!in_array($_FILES["image"]["type"], $allowedTypes)) {
            echo "Error: Only JPG or PNG images are allowed.";
            exit;
        }

        // Validate file extension
        $fileExtension = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
        if (!in_array(strtolower($fileExtension), $allowedExtensions)) {
            echo "Error: Invalid file extension. Only JPG or PNG images are allowed.";
            exit;
        }

        // Validate file size
        if ($_FILES["image"]["size"] > $maxFileSize) {
            echo "Error: File size exceeds the limit of 5MB.";
            exit;
        }

        // Generate a unique name for the image to avoid overwriting existing files
        $uniqueFileName = uniqid() . '_' . $_FILES["image"]["name"];
        $filePath = $uploadDir . $uniqueFileName;

        // Move the uploaded file to the desired directory
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $filePath)) {
            // File successfully uploaded, now you can save $filePath to the database
            // Example: Insert $filePath into your database table
            echo "File uploaded successfully.";
            // Example of inserting into database
            // $sql = "INSERT INTO images (file_path) VALUES ('$filePath')";
            // $result = mysqli_query($connection, $sql);
        } else {
            echo "Error uploading the file.";
        }
    } else {
        echo "Error: " . $_FILES["image"]["error"];
    }
}
