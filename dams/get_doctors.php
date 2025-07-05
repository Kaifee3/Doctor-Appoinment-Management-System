<?php
// Set headers for better performance and security
header('Content-Type: application/json');
header('Cache-Control: public, max-age=300'); // Cache for 5 minutes
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');

include('doctor/includes/dbconnection.php');

try {
    if(!empty($_POST["sp_id"])) {
        $spid = intval($_POST["sp_id"]); // Sanitize input
        
        // Use prepared statement for security
        $sql = $dbh->prepare("SELECT ID, FullName FROM tbldoctor WHERE Specialization = :spid ORDER BY FullName ASC");
        $sql->execute(array(':spid' => $spid));
        
        $doctors = array();
        while($row = $sql->fetch(PDO::FETCH_ASSOC)) {
            $doctors[] = array(
                'id' => $row['ID'],
                'name' => htmlspecialchars($row['FullName'])
            );
        }
        
        // Return JSON response
        echo json_encode(array(
            'success' => true,
            'doctors' => $doctors,
            'count' => count($doctors)
        ));
        
    } else {
        echo json_encode(array(
            'success' => false,
            'error' => 'Specialization ID is required'
        ));
    }
    
} catch (PDOException $e) {
    // Log error (in production, log to file)
    error_log("Database error in get_doctors.php: " . $e->getMessage());
    
    echo json_encode(array(
        'success' => false,
        'error' => 'Unable to fetch doctors at this time. Please try again later.'
    ));
} catch (Exception $e) {
    // Log error (in production, log to file)
    error_log("General error in get_doctors.php: " . $e->getMessage());
    
    echo json_encode(array(
        'success' => false,
        'error' => 'An unexpected error occurred. Please try again later.'
    ));
}
?>