
<?php
require 'db.php';

// Check if the form is submitted and if it's a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    // Check if the simulated HTTP method is 'delete'
    if ($_POST['_method'] === 'delete') {
        // Get the class ID from the POST data
        $id = isset($_POST['id']) ? intval($_POST['id']) : 0;

        if ($id > 0) {
            // Prepare and execute the SQL DELETE statement
            $sql = 'DELETE FROM student WHERE id = :id';
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['id' => $id]);

            // Redirect back to the manage page after deletion
            header('Location: index.php');
            exit;
        } else {
            echo "Invalid student ID.";
        }
    }
}
