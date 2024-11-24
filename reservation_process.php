<?php
session_start();
include('database.php');

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    die("Error: User not logged in.");
}

$user_id = $_SESSION['user_id']; // Retrieve user_id from the session
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$gender = $_POST['gender'];
$age = $_POST['age'];
$contact_number = $_POST['contact_number'];
$arrival_date = $_POST['arrival_date'];
$is_foreigner = isset($_POST['is_foreigner']) ? 1 : 0;
$is_group_reservation = isset($_POST['is_group_reservation']) ? 1 : 0;

// Handle the municipality field
$municipality = isset($_POST['municipality']) && !$is_foreigner ? $_POST['municipality'] : 'N/A';

// Set the timezone to the correct one (e.g., Asia/Manila)
date_default_timezone_set('Asia/Manila');

// Get the current timestamp
$timestamp = date('Y-m-d H:i:s');

// Calculate total fee for main customer
$total_fee = ($age <= 20) ? 100 : (($age <= 50) ? 200 : 150);

// Insert reservation details
$query = "INSERT INTO reservation (user_id, first_name, last_name, gender, age, municipality, contact_number, arrival_date, timestamp, is_foreigner, is_group_reservation, total_fee) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("isssissssiis", $user_id, $first_name, $last_name, $gender, $age, $municipality, $contact_number, $arrival_date, $timestamp, $is_foreigner, $is_group_reservation, $total_fee);

if ($stmt->execute()) {
    $reservation_id = $stmt->insert_id; // Get the inserted reservation ID

    // Handle group members
    if (!empty($_POST['group_members'])) {
        $group_members = json_decode($_POST['group_members'], true);

        $group_query = "INSERT INTO group_members (reservation_id, first_name, last_name, age, gender, municipality, is_foreigner) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $group_stmt = $conn->prepare($group_query);

        foreach ($group_members as $member) {
            $group_municipality = !$member['is_foreigner'] ? $member['municipality'] : 'N/A';
            $group_stmt->bind_param(
                "isssisi",
                $reservation_id,
                $member['first_name'],
                $member['last_name'],
                $member['age'],
                $member['gender'],
                $group_municipality,
                $member['is_foreigner']
            );
            $group_stmt->execute();

            // Add group member's fee to the total fee
            $member_age = intval($member['age']);
            $total_fee += ($member_age <= 20) ? 100 : (($member_age <= 50) ? 200 : 150);
        }
        $group_stmt->close();
    }

    // Update the total fee in the reservation table
    $update_query = "UPDATE reservation SET total_fee = ? WHERE reservation_id = ?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param("ii", $total_fee, $reservation_id);
    $update_stmt->execute();
    $update_stmt->close();

    // Redirect back to the main page with success status
    header("Location: loocsanctuary.php?status=success");
    exit();
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
