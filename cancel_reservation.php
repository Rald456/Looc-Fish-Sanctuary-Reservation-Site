<?php
include('database.php');

if (isset($_POST['reservation_id']) && isset($_POST['cancel_reason'])) {
    $reservation_id = intval($_POST['reservation_id']);
    $cancel_reason = mysqli_real_escape_string($conn, $_POST['cancel_reason']);

    // Insert the cancellation reason into the database
    $query = "INSERT INTO cancellation_reasons (reservation_id, reason) VALUES ('$reservation_id', '$cancel_reason')";
    if (mysqli_query($conn, $query)) {
        // Update the reservation status to 'Cancelled'
        $updateQuery = "UPDATE reservation SET status = 'Cancelled' WHERE reservation_id = '$reservation_id'";
        if (mysqli_query($conn, $updateQuery)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to update reservation status.']);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to record cancellation reason.']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request.']);
}
?>
