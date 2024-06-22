<?php
require 'db.php';

// Check if the form is submitted and if it's a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    // Check if the simulated HTTP method is 'delete'
    if ($_POST['_method'] === 'delete') {
        // Get the class ID from the POST data
        $class_id = isset($_POST['class_id']) ? intval($_POST['class_id']) : 0;

        if ($class_id > 0) {
            try {
                // Start a transaction to ensure data consistency
                $pdo->beginTransaction();

                // Delete students associated with the class
                $stmtDeleteStudents = $pdo->prepare('DELETE FROM student WHERE class_id = :class_id');
                $stmtDeleteStudents->execute(['class_id' => $class_id]);

                // Now delete the class itself
                $stmtDeleteClass = $pdo->prepare('DELETE FROM classes WHERE class_id = :class_id');
                $stmtDeleteClass->execute(['class_id' => $class_id]);

                // Commit the transaction
                $pdo->commit();

                // Redirect back to the manage page after deletion
                header('Location: manage.php');
                exit;
            } catch (PDOException $e) {
                // Rollback the transaction on error
                $pdo->rollBack();
                echo "Error deleting class and students: " . $e->getMessage();
            }
        } else {
            echo "Invalid class ID.";
        }
    }
}
