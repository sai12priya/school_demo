<?php
// Include database connection
include 'db.php'; // Assuming db.php contains your PDO connection

// Get the student ID from the query string
$studentId = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($studentId > 0) {
    try {
        // Prepare and execute the query to fetch student details
        $sql = "SELECT s.name, s.email, s.address, c.name as class, s.image, s.created_at
                FROM student s 
                JOIN classes c ON s.class_id = c.class_id 
                WHERE s.id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $studentId, PDO::PARAM_INT);
        $stmt->execute();

        $student = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($student) {
            // Send the student data as JSON
            echo json_encode($student);
        } else {
            // Send an error response if student not found
            echo json_encode(['error' => 'Student not found']);
        }
    } catch (PDOException $e) {
        // Send an error response if there's a database error
        echo json_encode(['error' => $e->getMessage()]);
    }
} else {
    // Send an error response if no valid student ID is provided
    echo json_encode(['error' => 'Invalid student ID']);
}

// Close the database connection
unset($pdo);
